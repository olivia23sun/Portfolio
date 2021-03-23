import numpy as np

A = np.array([[1, 2, 3], [4, 5, 6]])
B = np.array([[9, 8, 7], [6, 5, 4]])

A[1], B[1] = B[1], A[1]
print(A)
print(B)
