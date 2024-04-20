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
        <div style="width: 75%; margin: auto; display: flex; flex-direction: column; gap: 1em; border: 1px solid black;">
            <div style="margin: auto;">Ilość testów: <input id="numberOfTests" type="range" min="1" max="5" value="3"></input></div>
            <div style="margin: auto;">Rozmiar: 
                <select id="selectSize" onchange="changeSize()">
                    <option value="size0">mały – 30/30px</option>
                    <option value="size1" selected>średni – 45/45px</option>
                    <option value="size2">duży – 60/60px</option>
                </select>
            </div>
            <div style="margin: auto;">Ułożenie: 
                <select id="selectLayout" onchange="changeLayout()">
                    <option value="layout0" selected>w piątkę jak na kostce</option>
                    <option value="layout1">w przekątną lewą</option>
                    <option value="layout2">w przekątną prawą</option>
                    <option value="layout3">w linię poziomą na środku</option>
                    <option value="layout4">w linię pionową na środku</option>
                </select>
            </div>
            <button id="startButton" style="margin: auto;" onclick="handleTests()">Rozpocznij test</button>
            <div id="images" class="layout0">
                <img id="image0" src="assets/Lightbulb-Off.svg" class="size1">
                <img id="image1" src="assets/Lightbulb-Off.svg" width="50" height="50">
                <img id="image2" src="assets/Lightbulb-Off.svg" width="50" height="50">
                <img id="image3" src="assets/Lightbulb-Off.svg" width="50" height="50">
                <img id="image4" src="assets/Lightbulb-Off.svg" width="50" height="50">
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
            var selectedLayout = document.getElementById("selectLayout").options[document.getElementById("selectLayout").selectedIndex].text;
            var selectedSize = document.getElementById("selectSize").options[document.getElementById("selectSize").selectedIndex].text;

            document.getElementById("results").innerText += "Średni czas reakcji: " + averageReactionTime.toFixed(0) + " milisekund\n";
            document.getElementById("results").innerText += "Najkrótszy czas reakcji: " + shortestReactionTime + " milisekund\n";
            document.getElementById("results").innerText += "Najdłuższy czas reakcji: " + longestReactionTime + " milisekund\n";
            document.getElementById("results").innerText += "Łączny czas testu: " + totalReactionTime + " milisekund\n";
            document.getElementById("results").innerText += "Godzina zakończenia testu: " + endTime.getHours() + ":" + endTime.getMinutes() + ":" + endTime.getSeconds() + "\n";
            document.getElementById("results").innerText += "Wybrany układ rysunków: " + selectedLayout + "\n";
            document.getElementById("results").innerText += "Wybrana wielkość rysunków: " + selectedSize + "\n";
            document.getElementById("startButton").style.display = "inline";
        }

        function changeLayout() {
            var selectedLayout = document.getElementById("selectLayout").value;
            document.getElementById("images").setAttribute("class", selectedLayout);
        }

        function changeSize() {
            var selectedSize = document.getElementById("selectSize").value;
            var images = document.querySelectorAll("#images img");
            images.forEach(function(image) {
                image.setAttribute("class", selectedSize);
            });
        }

    </script>
    <script src="bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>
</html>
