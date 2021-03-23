from scanner import Scanner
from network import Network
from time import sleep
import numpy as np
import pykeyboard
import random
import copy
import time
import math
import os

class Generation:
    def __init__(self, driver):
        self.__genomes = [Network() for i in range(12)]
        self.__best_genomes = []
        self.driver = driver
        self.__superBest_genomes = Network()
    def execute(self):
        time.sleep(2)
        k = pykeyboard.PyKeyboard()
        scanner = Scanner(self.driver)
        for i, genome in enumerate(self.__genomes):
            print('---------------Genome Number: {0}---------------'.format(i+1))
            time.sleep(0.1)
            k.tap_key(' ')
            _ = self.wait_for_dino_jump(time.time())
            scanner.find_game()

            start_time = time.time()
            running_time = 0
            scanner.reset()
            t = 0
            jump = 0
            jumpDist = 0
            flag = True
            while flag:
                stop = 0
                t += 1
                obs = scanner.find_next_obstacle()
                if not stop:
                    inputs = [obs['distance'] / 100, obs['length'] / 100, obs['speed'] / 100] 
                    outputs = genome.forward(np.array(inputs, dtype=float))
                    if outputs[0] > 0.55:
                        k.tap_key(' ')
                        jump += 1
                        stop = 1
                print('speed: {0}'.format(obs['speed']))

                if stop:
                    StopTimeStart = time.time()
                    while True:
                        if (time.time() - StopTimeStart) >= 0.65:
                            obs = scanner.find_next_obstacle()
                            if obs['speed'] == 0:
                                flag = False #died
                                running_time = time.time() - start_time - 0.65
                                jumpDist = obs['distance']
                                break
                            else:
                                flag = True
                                stop = 0
                                break
                elif obs['speed'] == 0:
                    StopTimeStart = time.time()
                    while True:
                        if (time.time() - StopTimeStart) >= 0.65:
                            obs = scanner.find_next_obstacle()
                            if obs['speed'] == 0:
                                flag = False #died
                                running_time = time.time() - start_time - 0.65
                                jumpDist = 1000 #died because no jump, give high penalty
                                break
                            else:
                                flag = True
                                stop = 0
                                break 

            print('t: {0}'.format(t))
            genome.fitness = 1.5 * scanner.get_fitness() + 15 * running_time -   (jumpDist / 100)
            print('Gemome fitness: {0}'.format(genome.fitness))
            #print('W1: {0}'.format(genome.W1))
    def DeletePng(self):
        filename = 'tmp.png'
        if os.path.isfile(filename):
            print('remove')
            os.remove(filename)

    def keep_best_genomes(self):
        self.__genomes.sort(key=lambda x: x.fitness, reverse=True)
        self.__genomes = self.__genomes[:5]
        self.__best_genomes = self.__genomes[:]
        if self.__best_genomes[0].fitness > self.__superBest_genomes.fitness:
            self.__superBest_genomes = copy.deepcopy(self.__best_genomes[0])
        #else:
        #    if random.uniform(0, 1) < 0.65:
        #        self.__best_genomes[0] = copy.deepcopy(self.__superBest_genomes)

    def mutations(self):
        self.__genomes = []
        while len(self.__genomes) < 10:
            genome1 = random.choice(self.__best_genomes)
            genome2 = random.choice(self.__best_genomes)
            genome1, genome2 = self.cross_over(genome1, genome2)
            self.__genomes.append(self.mutate(genome1))
            self.__genomes.append(self.mutate(genome2))
        while len(self.__genomes) < 12:
            #genome = random.choice(self.__best_genomes)
            self.__genomes.append(self.__best_genomes[0])
            self.__genomes.append(self.__best_genomes[1])
        

    def cross_over(self, genome1, genome2):
        new_genome_1 = copy.deepcopy(genome1)
        new_genome_2 = copy.deepcopy(genome2)

        if random.uniform(0, 1) < 0.5:
            cut_location = int(len(new_genome_1.W1.T) * random.uniform(0, 1))
            for i in range(cut_location, len(new_genome_1.W1.T)):
                new_genome_1.W1.T[i], new_genome_2.W1.T[i] = genome2.W1.T[i], genome1.W1.T[i]
        if random.uniform(0, 1) < 0.5:
            cut_location = int(len(new_genome_1.W2.T) * random.uniform(0, 1))
            for i in range(cut_location, len(new_genome_1.W2.T)):
                new_genome_1.W2.T[i], new_genome_2.W2.T[i] = genome2.W2.T[i], genome1.W2.T[i]
        if random.uniform(0, 1) < 0.5:
            cut_location = int(len(new_genome_1.W3.T) * random.uniform(0, 1))
            for i in range(cut_location, len(new_genome_1.W3.T)):
                new_genome_1.W3.T[i], new_genome_2.W3.T[i] = genome2.W3.T[i], genome1.W3.T[i]
        if random.uniform(0, 1) < 0.5:
            cut_location = int(len(new_genome_1.W4.T) * random.uniform(0, 1))
            for i in range(cut_location, len(new_genome_1.W4.T)):
                new_genome_1.W4.T[i], new_genome_2.W4.T[i] = genome2.W4.T[i], genome1.W4.T[i]
        if random.uniform(0, 1) < 0.5:
            cut_location = int(len(new_genome_1.W5.T) * random.uniform(0, 1))
            for i in range(cut_location, len(new_genome_1.W5.T)):
                new_genome_1.W5.T[i], new_genome_2.W5.T[i] = genome2.W5.T[i], genome1.W5.T[i]
        '''
        cut_location = int(len(new_genome_1.W1.T) * random.uniform(0, 1))
        for i in range(cut_location, len(new_genome_1.W1.T)):
            new_genome_1.W1.T[i], new_genome_2.W1.T[i] = genome2.W1.T[i], genome1.W1.T[i]
        cut_location = int(len(new_genome_1.W2.T) * random.uniform(0, 1))
        for i in range(cut_location, len(new_genome_1.W2.T)):
            new_genome_1.W2.T[i], new_genome_2.W2.T[i] = genome2.W2.T[i], genome1.W2.T[i]
        for i in range(cut_location, len(new_genome_1.W3.T)):
            new_genome_1.W3.T[i], new_genome_2.W3.T[i] = genome2.W3.T[i], genome1.W3.T[i]
        '''
        return new_genome_1, new_genome_2

    def __mutate_weights(self, weights):
        if random.uniform(0, 1) < 0.1:
            return weights * (random.uniform(0, 1) - 0.5) * 3 + (random.uniform(0, 1) - 0.5)
        else:
            return 0

    def mutate(self, genome):
        new_genome = copy.deepcopy(genome)
        new_genome.W1 += self.__mutate_weights(new_genome.W1)
        new_genome.W2 += self.__mutate_weights(new_genome.W2)
        new_genome.W3 += self.__mutate_weights(new_genome.W3)
        new_genome.W4 += self.__mutate_weights(new_genome.W4)
        new_genome.W5 += self.__mutate_weights(new_genome.W5)

        return new_genome
    def wait_for_dino_jump(self, Time):
        while True: 
            if (time.time() - Time) >= 2:
                return 0
            

