from generation import Generation
from selenium import webdriver
from selenium.webdriver.chrome.options import Options

def main():
    driver = webdriver.Chrome()
    #driver.get('chrome://settings/clearBrowserData')
    #driver.find_element_by_xpath('//settings-ui').send_keys(Keys.ENTER)
    driver.get('chrome://dino')
    generation = Generation(driver)
    iteration = 0
    while True:
        iteration += 1
        print('++++++++++++++++++++++++++++++++++++++++++++++++++')
        print('                  iteration:{0}'.format(iteration) )
        print('++++++++++++++++++++++++++++++++++++++++++++++++++')
        generation.execute()
        generation.keep_best_genomes()
        generation.mutations()

if __name__ == '__main__':
    main()
