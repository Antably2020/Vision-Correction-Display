from colorBlindness_recolor import Core


def main():
        # Correcting Image for Hybrid with diagnosed degree of 1.0 for both protanopia and
    # deutranopia and saving the image to file.
    Core.correct(input_path='Examples_Check/rabbit.jpg',
                 return_type='save',
                 save_path='Examples_Check/ex_corrected_hybrid.png',
                 protanopia_degree=0.5,
                 deutranopia_degree=0.5)
    
    # You can also use different return types and get numpy array or PIL.Image for further processing.
    # See recolor.py
    return


if __name__ == '__main__':
    main()
