# l-bfgs-b algorithm local optimization of a convex function
from scipy.optimize import minimize
from numpy.random import rand
import numpy as np
# objective function
def objective(x):
	return x[0]*2.0 + x[1]*2.0
 
# derivative of the objective function
def derivative(x):
	return [x[0] * 2, x[1] * 2]
    
def lbfgsb():
# define the starting point 
    x0=np.zeros((Display.Screen_Res^2*5*5,1))
    # perform the l-bfgs-b algorithm search
    result = minimize(objective, pt, method='L-BFGS-B', jac=derivative, 
                      options={'ftol': 1e-03, 'gtol': 1e-06, 'maxiter': 100, 'iprint': 10})
    # summarize the result
    print('Status : %s' % result['message'])
    print('Total Evaluations: %d' % result['nfev'])
    # evaluate solution
    solution = result['x']
    evaluation = objective(solution)
    print('Solution: f(%s) = %.5f' % (solution, evaluation))
    return solution