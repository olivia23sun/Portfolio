import numpy as np

class Network:
    def __init__(self):
        self.input_size = 3
        #self.hidden_size = 4
        self.output_size = 1
        self.W1 = np.random.randn(self.input_size, 64)
        self.W2 = np.random.randn(64, 32)
        self.W3 = np.random.randn(32, 16)
        self.W4 = np.random.randn(16, 4)
        self.W5 = np.random.randn(4, self.output_size)
        self.fitness = 0

    def forward(self, inputs):
        #self.z2 = np.dot(inputs, self.W1)
        #self.a2 = np.tanh(self.z2)
        #self.z3 = np.dot(self.a2, self.W2)
        #self.a3 = np.tanh(self.z3)
        #self.z4 = np.dot(self.a3, self.W3)
        #yHat = sigmoid(self.z3)
        self.z2 = np.dot(self.W1.T, inputs)
        self.a2 = self.LeakyReLU(self.z2)
        self.z3 = np.dot(self.W2.T, self.a2)
        self.a3 = self.LeakyReLU(self.z3)
        self.z4 = np.dot(self.W3.T, self.a3)
        self.a4 = self.LeakyReLU(self.z4)
        self.z5 = np.dot(self.W4.T, self.a4)
        self.a5 = self.LeakyReLU(self.z5)
        self.z6 = np.dot(self.W5.T, self.a5)
        yHat = self.sigmoid(self.z6)
        return yHat

    def sigmoid(self, z):
        return .5 * (1 + np.tanh(.5 * z))
        #return 1 / (1 + np.exp(-z))

    def LeakyReLU(self, x, alpha = 0.01):
        return np.where(x>0, x, x * alpha)
