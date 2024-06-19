<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculateur de PageRank</title>
    <link rel="stylesheet" href="style.css">
    <script src="//unpkg.com/3d-force-graph"></script>
</head>
<body>
    <div class="container">
        <h1 id="title">Calculateur de PageRank</h1>
        <form id="pagerankForm" method="post" action="pagerank.php">
            <label for="initialPR" id="labelInitialPR">PageRank initial de votre page :</label>
            <input type="number" id="initialPR" name="initialPR" step="0.01" required>
            
            <label for="numNewPages" id="labelNumNewPages">Nombre de nouvelles pages à créer :</label>
            <input type="number" id="numNewPages" name="numNewPages" required>
            
            <button type="submit" id="submitButton">Calculer le PageRank</button>
        </form>
        <div id="results"></div>
        <div class="button-group">
            <button id="adminButton">Paramètres Admin</button>
            <button id="langButton">English</button>
            <a href="help.html" id="helpLink">Aide</a>
        </div>
    </div>
    <div class="graph-container">
        <div id="calculationDetails"></div>
        <div id="3d-graph"></div>
        <button id="backToTopButton" onclick="scrollToTop()">Retour en haut de page</button>
    </div>

    <!-- Modal for admin settings -->
    <div id="adminModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="adminTitle">Paramètres Admin</h2>
            <label for="dampingFactor" id="labelDampingFactor">Facteur d'amortissement :</label>
            <input type="number" id="dampingFactor" step="0.01" value="0.85">
            <button id="saveSettings">Sauvegarder</button>
        </div>
    </div>

    <script>
        document.getElementById('pagerankForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            formData.append('dampingFactor', localStorage.getItem('dampingFactor') || 0.85);
            fetch('pagerank.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                let resultsDiv = document.getElementById('results');
                resultsDiv.innerHTML = `<h2>PageRank Cible: ${data.targetPR.toFixed(4)}</h2>`;
                generateGraph(data.numNewPages, formData.get('initialPR'), data.targetPR, formData.get('dampingFactor'));
            });
        });

        function generateGraph(numNewPages, initialPR, targetPR, dampingFactor) {
            const nodes = [{ id: 'Page Cible', group: 1 }];
            const links = [];

            for (let i = 1; i <= numNewPages; i++) {
                const newNode = { id: `Page ${i}`, group: 2 };
                nodes.push(newNode);
                links.push({ source: newNode.id, target: 'Page Cible', value: 1 });
            }

            const Graph = ForceGraph3D()
                (document.getElementById('3d-graph'))
                .graphData({ nodes, links })
                .nodeLabel('id')
                .nodeAutoColorBy('group')
                .linkDirectionalParticles(4)
                .linkDirectionalParticleSpeed(d => d.value * 0.01)
                .linkDirectionalParticleWidth(2);

            // Display calculation details above the graph area
            const calculationDetails = document.getElementById('calculationDetails');
            calculationDetails.innerHTML = `
                <p>Initial PageRank: ${initialPR}</p>
                <p>Number of New Pages: ${numNewPages}</p>
                <p>Damping Factor: ${dampingFactor}</p>
                <p>Target PageRank: ${targetPR.toFixed(4)}</p>
            `;
            calculationDetails.style.color = 'white';
            calculationDetails.style.marginBottom = '10px';

            // Enable pointer events after the graph is created to allow interactions
            document.getElementById('3d-graph').style.pointerEvents = 'auto';
        }

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Modal handling
        var modal = document.getElementById("adminModal");
        var btn = document.getElementById("adminButton");
        var span = document.getElementsByClassName("close")[0];
        var saveButton = document.getElementById("saveSettings");

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        saveButton.onclick = function() {
            var dampingFactor = document.getElementById("dampingFactor").value;
            localStorage.setItem("dampingFactor", dampingFactor);
            modal.style.display = "none";
        }

        // Apply saved settings
        window.onload = function() {
            if (localStorage.getItem("dampingFactor")) {
                document.getElementById("dampingFactor").value = localStorage.getItem("dampingFactor");
            }
        }

        // Language toggle handling
        var langButton = document.getElementById("langButton");
        langButton.onclick = function() {
            var currentLang = langButton.innerText;
            if (currentLang === "English") {
                setLanguage("en");
            } else {
                setLanguage("fr");
            }
        }

        function setLanguage(lang) {
            if (lang === "en") {
                document.getElementById("title").innerText = "PageRank Calculator";
                document.getElementById("labelInitialPR").innerText = "Initial PageRank of your page:";
                document.getElementById("labelNumNewPages").innerText = "Number of new pages to create:";
                document.getElementById("submitButton").innerText = "Calculate PageRank";
                document.getElementById("adminButton").innerText = "Admin Settings";
                document.getElementById("langButton").innerText = "Français";
                document.getElementById("adminTitle").innerText = "Admin Settings";
                document.getElementById("labelDampingFactor").innerText = "Damping Factor:";
                saveButton.innerText = "Save";
                document.getElementById("helpLink").innerText = "Help";
                document.getElementById("helpLink").href = "help.html";
            } else {
                document.getElementById("title").innerText = "Calculateur de PageRank";
                document.getElementById("labelInitialPR").innerText = "PageRank initial de votre page :";
                document.getElementById("labelNumNewPages").innerText = "Nombre de nouvelles pages à créer :";
                document.getElementById("submitButton").innerText = "Calculer le PageRank";
                document.getElementById("adminButton").innerText = "Paramètres Admin";
                document.getElementById("langButton").innerText = "English";
                document.getElementById("adminTitle").innerText = "Paramètres Admin";
                document.getElementById("labelDampingFactor").innerText = "Facteur d'amortissement :";
                saveButton.innerText = "Sauvegarder";
                document.getElementById("helpLink").innerText = "Aide";
                document.getElementById("helpLink").href = "help.html";
            }
        }

        // Initialize language to French
        setLanguage("fr");
    </script>
</body>
</html>
