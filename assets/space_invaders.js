const grid = document.querySelector(".grid")
const resultDisplay = document.querySelector(".results")
let currentShooterIndex = 202
const width = 15
let aliensRemoved = []
let invadersId
let results = 0
let speed = 2000 // Initial speed in milliseconds

// Initialiser la grille
for (let i = 0; i < width * width; i++) {
    const square = document.createElement("div")
    grid.appendChild(square)
}

const squares = Array.from(document.querySelectorAll(".grid div"))

const initialAlienInvaders = [
    0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
    15, 16, 17, 18, 19, 20, 21, 22, 23, 24,
    30, 31, 32, 33, 34, 35, 36, 37, 38, 39
]

let alienInvaders = [...initialAlienInvaders]

// Fonction pour dessiner les envahisseurs
function draw() {
    for (let i = 0; i < alienInvaders.length; i++) {
        if (!aliensRemoved.includes(i)) {
            squares[alienInvaders[i]].classList.add("invader")
        }
    }
}

draw()

squares[currentShooterIndex].classList.add("shooter")

// Fonction pour retirer les envahisseurs
function remove() {
    for (let i = 0; i < alienInvaders.length; i++) {
        squares[alienInvaders[i]].classList.remove("invader")
    }
}

// Déplacement du tireur
function moveShooter(e) {
    squares[currentShooterIndex].classList.remove("shooter")
    switch (e.key) {
        case "ArrowLeft":
            if (currentShooterIndex % width !== 0) currentShooterIndex -= 1
            break
        case "ArrowRight":
            if (currentShooterIndex % width < width - 1) currentShooterIndex += 1
            break
    }
    squares[currentShooterIndex].classList.add("shooter")
}

document.addEventListener("keydown", moveShooter)

// Déplacement des envahisseurs
function moveInvaders() {
    remove()

    // Déplacer les envahisseurs vers le bas
    for (let i = 0; i < alienInvaders.length; i++) {
        alienInvaders[i] += width
    }

    draw()

    // Vérifier si un envahisseur touche le tireur
    if (squares[currentShooterIndex].classList.contains("invader")) {
        resultDisplay.innerHTML = "GAME OVER"
        clearInterval(invadersId)
    }

    // Réinitialiser la position des envahisseurs si tous ont été tués
    if (aliensRemoved.length === initialAlienInvaders.length) {
        remove()
        alienInvaders = [...initialAlienInvaders]
        aliensRemoved = []
        draw()
    }

    // Réinitialiser la position des envahisseurs si tous atteignent le bas
    if (alienInvaders.some(invader => invader >= width * width)) {
        remove()
        alienInvaders = alienInvaders.filter((_, index) => !aliensRemoved.includes(index));
        alienInvaders = alienInvaders.map(invader => invader % width); // Réinitialiser à la première ligne
        aliensRemoved.length = 0
        draw()
    }

    // Accélérer les envahisseurs tous les 30 points
    if (results > 0 && results % 30 === 0) {
        clearInterval(invadersId)
        speed = Math.max(100, speed - 100) // Diminuer la vitesse, mais ne pas aller en dessous de 100ms
        invadersId = setInterval(moveInvaders, speed)
    }
}

invadersId = setInterval(moveInvaders, speed) // Utiliser la vitesse initiale

// Tir du laser
function shoot(e) {
    let laserId
    let currentLaserIndex = currentShooterIndex

    function moveLaser() {
        squares[currentLaserIndex].classList.remove("laser")
        currentLaserIndex -= width
        if (currentLaserIndex < 0) {
            clearInterval(laserId)
            return
        }
        squares[currentLaserIndex].classList.add("laser")

        if (squares[currentLaserIndex].classList.contains("invader")) {
            squares[currentLaserIndex].classList.remove("laser")
            squares[currentLaserIndex].classList.remove("invader")
            squares[currentLaserIndex].classList.add("boom")

            setTimeout(() => squares[currentLaserIndex].classList.remove("boom"), 300)
            clearInterval(laserId)

            const alienRemoved = alienInvaders.indexOf(currentLaserIndex)
            aliensRemoved.push(alienRemoved)
            results++
            resultDisplay.innerHTML = results
        }
    }

    if (e.key === " ") {
        laserId = setInterval(moveLaser, 100)
    }
}

document.addEventListener('keydown', shoot)
