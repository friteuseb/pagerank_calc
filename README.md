# PageRank Calculator

This project is a PageRank Calculator web application that allows users to calculate the PageRank of a webpage based on the number of internal pages linking to it. It uses D3.js for visualizing the graph and provides an interactive interface for adjusting parameters.

## Features

- Calculate PageRank based on initial PageRank and number of new pages.
- Visualize the graph of pages linking to the target page.
- Adjust the damping factor via admin settings.
- Toggle between English and French languages.
- Provide a help page with explanations of the PageRank calculation.

## Getting Started

### Prerequisites

You need a web server with PHP support to run this application.

### Installation

1. Clone this repository to your web server's root directory.

    ```bash
    git clone https://github.com/friteuseb/pagerank_calc.git
    ```

2. Navigate to the directory.

    ```bash
    cd pagerank_calc
    ```

3. Open the application in your web browser.

    ```bash
    http://localhost/pagerank_calc
    ```

## Usage

1. **Enter Initial PageRank**: Enter the initial PageRank of your page.
2. **Enter Number of New Pages**: Enter the number of new pages to create and link to the target page.
3. **Calculate PageRank**: Click on the "Calculer le PageRank" button to calculate the target PageRank.
4. **View Graph**: The graph visualizes the target page and the new pages linking to it, with details of the calculation displayed.

### Admin Settings

- **Adjust Damping Factor**: Click on the "Paramètres Admin" button to open the modal for adjusting the damping factor. Enter a new value and click "Sauvegarder".

### Language Toggle

- **Switch Language**: Click on the "English" button to switch to English, or "Français" to switch to French.

### Help Page

- **View Help**: Click on the "Aide" link to view the help page with explanations of the PageRank calculation.

## Files

- `index.php`: Main application file.
- `style.css`: CSS file for styling the application.
- `pagerank.php`: PHP file for handling the PageRank calculation.
- `help.html`: Help page with explanations of the PageRank calculation.

## Contributing

If you would like to contribute, please fork the repository and use a feature branch. Pull requests are warmly welcome.

## License

This project is licensed under the MIT License.

## Acknowledgements

- [D3.js](https://d3js.org/)

