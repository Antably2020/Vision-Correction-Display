import argparse
import os

import numpy as np
from PIL import Image
import cv2

from utils import Transforms, Utils


class Core:


    @staticmethod
    def correct(input_path: str,
                protanopia_degree: float = 1.0,
                deutranopia_degree: float = 1.0,
                return_type: str = 'save',
                save_path: str = None
                ):
        """
        Use this method to correct images for People with Colorblindness. The images can be corrected for anyone
        having either protanopia, deutranopia, or both. Pass protanopia_degree and deutranopia_degree as diagnosed
        by a doctor using Ishihara test.
        :param input_path: Input path of the image.
        :param protanopia_degree: Protanopia degree as diagnosed by doctor using Ishihara test.
        :param deutranopia_degree: Deutranopia degree as diagnosed by doctor using Ishihara test.
        :param return_type: How to return the Simulated Image. Use 'pil' for PIL.Image, 'np' for Numpy array,
                            'save' for Saving to path.
        :param save_path: Where to save the simulated file. Valid only if return_type is set as 'save'.
        """

        img_rgb = Utils.load_rgb(input_path)[:,:,:3]
        transform = Transforms.correction_matrix(protanopia_degree=protanopia_degree,
                                                 deutranopia_degree=deutranopia_degree)

        img_corrected = np.uint8(np.dot(img_rgb, transform) * 255)
    
        if return_type == 'save':
            assert save_path is not None, 'No save path provided.'
            cv2.imwrite(save_path, img_corrected)
            return

        if return_type == 'np':
            return img_corrected

        if return_type == 'pil':
            return Image.fromarray(img_corrected)


def parse_args():
    parser = argparse.ArgumentParser(
        description='Simulate and Correct Images for Color-Blindness')
    parser.add_argument(
        'Examples_Check/rabbit.jpg', type=str, help='Path to input image.')
    parser.add_argument(
        'Examples_Check/', type=str, help='Path to save the output image dir.')
    parser.add_argument('-sim_protanopia', action='store_true', default=False,
                        help='Simulate Protanopia (Common Red-Green  Blindness)')
    parser.add_argument('-sim_deutranopia', action='store_true', default=False,
                        help='Simulate Deutranopia (Rare Red-Green Blindness)')
    parser.add_argument('-sim_tritanopia', action='store_true', default=False,
                        help='Simulate Tritanopia (Blue-Yellow Color Blindness)')
    parser.add_argument('-sim_hybrid', action='store_true', default=False,
                        help='Simulate a Hybrid Colorblindness (Protanopia + Deutranopia)')
    parser.add_argument('-correct_colors', action='store_true', default=False,
                        help='Correct Image for Protanopia')
    parser.add_argument('-run_all', action='store_true', default=False,
                        help='Perform all simulations and corrections.')
    parser.add_argument('-protanopia_degree', type=float, default=1.0,
                        help='Adjust the degree of Protanopia. Default is 1.0')
    parser.add_argument('-deutranopia_degree', type=float, default=1.0,
                        help='Adjust the degree of Deutranopia. Default is 1.0')
    parser.add_argument('-tritanopia_degree', type=float, default=1.0,
                        help='Adjust the degree of Tritanopia. Default is 1.0')
    args = parser.parse_args()

    return args


def main():
    args = parse_args()

    # Fetch the input and output paths.
    input_path = args.input
    image_name = input_path.split('/')[-1]
    output_path = args.output

    # Check if output path is a directory.
    assert os.path.isdir(output_path), 'Output path must be a Directory.'

    # Setup the run_all flag.
    run_all = False
    if args.run_all:
        run_all = True

    

    if args.correct_colors or run_all:
        Core.correct(input_path=input_path,
                     return_type='save',
                     save_path='{}/{}_{}'.format(output_path, 'correct_colors', image_name),
                     protanopia_degree=args.protanopia_degree,
                     deutranopia_degree=args.deutranopia_degree)

    print('ReColorLib completed running! Check output images in {}'.format(output_path))


if __name__ == '__main__':
    main()
