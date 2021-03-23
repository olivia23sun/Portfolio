from PIL import Image
from datetime import datetime
import os
import time
import base64

dino_color = (83, 83, 83, 255)

def screenshot(driver):
    
    try:
      #os.system("scrot  tmp.png")
      #https://stackoverflow.com/questions/38316402/how-to-save-a-canvas-as-png-in-selenium
      
      canvas = driver.find_element_by_class_name("runner-canvas")
      canvas_base64 = driver.execute_script("return arguments[0].toDataURL('image/png').substring(21);", canvas)
      # decode
      canvas_png = base64.b64decode(canvas_base64)
      # save to a file
      with open(r"tmp.png", 'wb') as f:
          f.write(canvas_png)
      img = Image.open("tmp.png")
    except:
      print('Wrong!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!')
    return img

def is_dino_color(pixel):
    return pixel == dino_color

def obstacle(distance, length, speed, time):
    return { 'distance': distance, 'length': length, 'speed': speed, 'time': time }

class Scanner:
    def __init__(self, driver):
        self.dino_start = (0, 0)
        self.dino_end = (0, 0)
        self.dino_height = 0
        self.dino_Mostright = 0
        self.last_obstacle = {}
        self.__current_fitness = 0
        self.__change_fitness = False
        self.driver = driver
        self.pixels = []
        self.speed = 0
        self.lastObs = { 'distance': 200, 'length': 0, 'time': 0, 'speed': 0}

    def find_game(self):
        image = screenshot(self.driver)
        size = image.size
        #pixels = []
        y_axis = size[1]
        x_axis = size[0]
        flag = False
        #just check where the dino  will range in
        for x in range(0, x_axis):
            for y in range(0, y_axis):
                color = image.getpixel((x, y))
                if is_dino_color(color): 
                    new_x_axis = x + 67 #exceed 60, the y axis of each pixel will stuck in 131(I think it is because of  the underline)
                    flag = True
                    break
            if flag:
                break
        #-----------------k--------------------------
        for x in range(0, new_x_axis+1):
            for y in range(0, y_axis):
                color = image.getpixel((x, y))
                #print('color: {0}'.format(color))
                if is_dino_color(color):
                    self.pixels.append((x, y))

        if not self.pixels:
            raise Exception("Game not found!")

        self.__find_dino(self.pixels)

    def __find_dino(self, pixels):
        #print(pixels)
        #start = pixels[0]
        #end = pixels[-1]
        self.dino_start = pixels[0]
        self.dino_end = pixels[-1]
        self.height = max(pixels, key=lambda x: x[1])[1] - min(pixels, key=lambda x: x[1])[1]
        self.Mostright = max(pixels, key=lambda x: x[0])[0]
        if self.height > 100:
            self.height = 80
        print('dino height: {0}'.format(self.height))
        print('dino Mostright: {0}'.format(self.Mostright))

    def find_next_obstacle(self):
        self.time = time.time() #get current time
        image = screenshot(self.driver)
        next_obstacle_position = self.__next_obstacle_position(image)
        print('next_obstacle_position: {0}'.format(next_obstacle_position))
        dist = 1000
        if next_obstacle_position != 0: #can detect the obstacle
            dist = next_obstacle_position - self.dino_end[0] #dist between dino and obstacle now!!
            obstacle_data = self.__get_obstacle_data(next_obstacle_position, image)
            print('obstacle_data: {0}'.format(obstacle_data))
            if self.lastObs['distance'] != 200:
                self.speed = (self.lastObs['distance'] - dist) / (self.time - self.lastObs['time']) 
            self.lastObs['distance'] = dist
            self.lastObs['length'] = obstacle_data[1]
            self.lastObs['time'] = self.time
        else:
            self.speed = 400
        self.speed = abs(self.speed) #prevent self.speed become < 0
        self.lastObs['speed'] = self.speed
        print('minus: {0}'.format(self.lastObs['distance'] - dist))
        print('dist: {0}'.format(dist))
        if dist <= 50 and not self.__change_fitness:
            self.__current_fitness += 1
            self.__change_fitness = True
        elif dist > 50:
            self.__change_fitness = False

        #self.last_obstacle = obstacle(dist, 1, self.speed, self.time)
        return self.lastObs

    def __next_obstacle_position(self, image):
        size = image.size
        s = 0
        print('dino: start{0}'.format(self.dino_start))
        print('dino end{0}'.format(self.dino_end))
        
        for x in range(self.dino_end[0]+5, size[0]):
            for y in range( self.dino_end[1] - self.height, self.dino_end[1] - 10 ): 
                color = image.getpixel((x, y))
                if is_dino_color(color):
                    return x
        return 0

    def reset(self):
        self.lastObs = { 'distance': 200, 'length': 0, 'time': 0, 'speed': 0}
        print(self.lastObs)
        self.__current_fitness = 0
        self.__change_fitness = False

    def get_fitness(self):
        return self.__current_fitness

    def __get_obstacle_data(self, position, image):
        obstacle_data = [position, 0, 0]
        heightList = []
        # we try to check that on the specific x_axis, the range of the y_axis can find the obstacle or not
        for i in range(position, image.size[0]):
            flag = False
            for j in range( (self.dino_end[1] - 2), (self.dino_end[1] - self.height - 10),-1): #scan from line to dino head
                color = image.getpixel((i, j))
                if is_dino_color(color):
                    flag = True
                    heightList.append(j)
            if flag:
                obstacle_data[1] = i - position
            else:
                break
        obstacle_data[2] = min(heightList)
        return obstacle_data

    def __dinoJump(self, obstacle_data, image):
        obs_center = obstacle_data
        point = (dino_center, self.dino_end[1] - 1.5 * self.height)
        color = image.getpixel(point)
        if is_dino_color(color):
            return True
        return False

    def DownToFloor(self):
        image = screenshot(self.driver)
        for pixel in self.keypoint:
            if not is_dino_color(image.getpixel(pixel)):
                print('bad pixel: {0}'.format(pixel))
                return False
        print('YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY')
        return True 
