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
        <div style="width: 50%; margin: auto; display: flex; flex-direction: column;">
            <button id="startButton" style="margin: auto;" onclick="startTest()">Rozpocznij test</button><br><br>
            <img id="image" src="assets/Lightbulb-Off.svg" width="200" height="200" style="margin: auto;">
            <div id="result"></div>
        </div>
    </div>
    <script>
        var reactionTimes = [];
        var lightbulbOn = false;
        var startTime = null;
        var timeOut = null;

        function startTest() {
            document.getElementById("startButton").style.display = "none"; // Ukrycie przycisku po kliknięciu
            timeOut = setTimeout(changeImage, Math.floor(Math.random() * 2000) + 2000); // Losowy czas zmiany obrazka po kliknięciu przycisku
            
            document.getElementById("image").addEventListener("click", countTime);
        }
        
        function changeImage() {
            startTime = new Date().getTime();
            document.getElementById("image").src = "assets/Lightbulb-On.svg";
            document.getElementById("image").style.cursor = "pointer";
            lightbulbOn = true;
        }

        function countTime() {
            if (lightbulbOn) {
                var endTime = new Date().getTime();
                var reactionTime = endTime - startTime;
                reactionTimes.push(reactionTime);
                document.getElementById("result").innerText = "Poprzedni czas reakcji: " + reactionTime + " milisekund";
            }
            else {
                document.getElementById("result").innerText = "zbyt wczesnie";
            }
            resetTest();
        }

        function resetTest() {
            document.getElementById("image").src = "assets/Lightbulb-Off.svg";
            document.getElementById("image").removeEventListener("click", countTime);
            clearTimeout(timeOut);
            document.getElementById("startButton").style.display = "inline";
            lightbulbOn = false;
        }
    </script>
    <script src="bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>

</html>