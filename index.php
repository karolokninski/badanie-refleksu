<!DOCTYPE html>
<html>
<head>
    <title>Badanie refleksu</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Test czasu reakcji</h1>
        <p>Zobaczysz pięć zgaszonych żarówek. Losowo jedna z nich się zaświeci. Twoim zadaniem będzie kliknąć na świecącą się żarówkę. Twój wynik pojawi się zaraz po zakończeniu testu.</p>
        <div style="width: 75%; margin: auto; display: flex; flex-direction: column; gap: 1em;">
            <div style="margin: auto;">Ilość testów: <input id="numberOfTests" type="range" min="1" max="5" value="3"></input></div>
            <button id="startButton" style="margin: auto;" onclick="handleTests()">Rozpocznij test</button>
            <div>
            <img id="image0" src="assets/Lightbulb-Off.svg" width="100" height="100" style="margin: auto;">
            <img id="image1" src="assets/Lightbulb-Off.svg" width="100" height="100" style="margin: auto;">
            <img id="image2" src="assets/Lightbulb-Off.svg" width="100" height="100" style="margin: auto;">
            <img id="image3" src="assets/Lightbulb-Off.svg" width="100" height="100" style="margin: auto;">
            <img id="image4" src="assets/Lightbulb-Off.svg" width="100" height="100" style="margin: auto;">
            </div>
            <div id="currentResults"></div>
        </div>
        <h3>Twój wyniki:</h3>
        <div id="results"></div>
    </div>
    <script>
        var reactionTimes = [];
        var lightbulbOn = false;
        var startTime = null;
        var timeOut = null;
        var testsLeft = 0;
        var currentLightbulb = null;

        function handleTests() {
            reactionTimes = [];
            document.getElementById("results").innerText = "";
            testsLeft = document.getElementById("numberOfTests").value;
            document.getElementById("startButton").style.display = "none";
            startTest();
        }

        function startTest() {
            if (testsLeft > 0) {
                testsLeft--;
                var randomLightbulb = Math.floor(Math.random() * 5); // Losowo wybieramy jedną żarówkę (liczby od 0 do 4)
                currentLightbulb = "image" + randomLightbulb;
                timeOut = setTimeout(changeImage, Math.floor(Math.random() * 2000) + 1000);
                document.getElementById(currentLightbulb).addEventListener("click", countTime);
            } else {
                displayResults();
            }
        }
        
        function changeImage() {
            startTime = new Date().getTime();
            document.getElementById(currentLightbulb).src = "assets/Lightbulb-On.svg";
            document.getElementById(currentLightbulb).style.cursor = "pointer";
            lightbulbOn = true;
        }

        function countTime() {
            if (lightbulbOn) {
                var endTime = new Date().getTime();
                var reactionTime = endTime - startTime;
                reactionTimes.push(reactionTime);
                document.getElementById("currentResults").innerText = "Obecny czas reakcji: " + reactionTime + " milisekund\n";
            }
            else {
                document.getElementById("currentResults").innerText = "Zbyt wczesnie\n";
            }
            resetTest();
            startTest();
        }

        function resetTest() {
            document.getElementById(currentLightbulb).src = "assets/Lightbulb-Off.svg";
            document.getElementById(currentLightbulb).removeEventListener("click", countTime);
            document.getElementById(currentLightbulb).style.cursor = "auto";
            clearTimeout(timeOut);
            lightbulbOn = false;
        }

        function displayResults() {
            document.getElementById("results").innerText += "Ilość przeprowadzonych prób testu: " + reactionTimes.length + "\n";

            var totalReactionTime = 0;
            var shortestReactionTime = Infinity;
            var longestReactionTime = 0;
            for (var i = 0; i < reactionTimes.length; i++) {
                totalReactionTime += reactionTimes[i];
                if (reactionTimes[i] < shortestReactionTime) {
                    shortestReactionTime = reactionTimes[i];
                }
                if (reactionTimes[i] > longestReactionTime) {
                    longestReactionTime = reactionTimes[i];
                }
                document.getElementById("results").innerText += "Próba " + (i + 1) + ": " + reactionTimes[i] + " milisekund\n";
            }
            var averageReactionTime = totalReactionTime / reactionTimes.length;
            var endTime = new Date();

            // g. Wybrany dla testu układ rysunków - tutaj można dodać kod do uzyskania wybranego układu rysunków, jeśli jest to relevantne
            // h. Wybrana dla testu wielkość rysunków - tutaj można dodać kod do uzyskania wybranej wielkości rysunków, jeśli jest to relevantne

            document.getElementById("results").innerText += "Średni czas reakcji: " + averageReactionTime.toFixed(0) + " milisekund\n";
            document.getElementById("results").innerText += "Najkrótszy czas reakcji: " + shortestReactionTime + " milisekund\n";
            document.getElementById("results").innerText += "Najdłuższy czas reakcji: " + longestReactionTime + " milisekund\n";
            document.getElementById("results").innerText += "Łączny czas testu: " + totalReactionTime + " milisekund\n";
            document.getElementById("results").innerText += "Godzina zakończenia testu: " + endTime.getHours() + ":" + endTime.getMinutes() + ":" + endTime.getSeconds() + "\n\n";

            document.getElementById("startButton").style.display = "inline";
        }

    </script>
    <script src="bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>
</html>
