const pages = document.querySelectorAll('.page');
const next = document.getElementById('next');
const prev = document.getElementById('prev');

let current = 0;
let unlockedChapter = 1;
let points = 0;

// Display points
const scoreDisplay = document.createElement("div");
scoreDisplay.style.position = "fixed";
scoreDisplay.style.top = "60px";
scoreDisplay.style.left = "20px";
scoreDisplay.style.background = "white";
scoreDisplay.style.padding = "10px";
scoreDisplay.style.fontSize = "20px";
scoreDisplay.style.zIndex = "20";
scoreDisplay.innerHTML = "Points: 0";
document.body.appendChild(scoreDisplay);

// Correct answers for each chapter (all lowercase)
const answers = {
    1: ["venus", "cupid", "he accidentally shoot himself"],
    2: ["apollo", "zephyr", "she wants to see her sisters"],
    3: ["they marvel with jealousy", "doubt and fear consumed her", "trust"],
    4: ["venus", "sorting a mountain of seeds before dawn", "descend to the underworld and carry a box to fill it with proserpine's beauty"],
    5: ["cupid", "jupiter", "no"]
};

// Map chapter number to page index of the quiz
const quizPages = {
    1: 2,
    2: 5,
    3: 11,
    4: 14,
    5: 17
};

// Add points
function addPoints() {
    points += 10;
    scoreDisplay.innerHTML = "Points: " + points;
}

// Update next/prev buttons visibility
function updateButtons() {
    prev.style.display = current === 0 ? 'none' : 'inline-block';
    next.style.display = current === pages.length - 1 ? 'none' : 'inline-block';
}

// Check chapter answers
function checkChapter(chapter) {
    if (chapter !== unlockedChapter) {
        alert("This chapter is locked!");
        return;
    }

    let correct = 0;
    for (let i = 1; i <= 3; i++) {
        const input = document.getElementById(`c${chapter}q${i}`).value.toLowerCase().trim();
        if (input === answers[chapter][i - 1]) correct++;
    }

    if (correct === 3) {
        alert(`Chapter ${chapter} Passed!`);
        addPoints();
        unlockedChapter++;

        // Flip current page
        const pageIndex = quizPages[chapter];
        pages[pageIndex].classList.add('flipped');
        current = pageIndex + 1;
        updateButtons();

        if (chapter === 5) {
            alert("🎉 Congratulations! You finished all chapters!");
        }
    } else {
        alert("You must answer ALL questions correctly to unlock the next chapter.");
    }
}

// Next button logic
next.onclick = () => {
    // Check if next page is a locked quiz page
    for (const chapter in quizPages) {
        if (current === quizPages[chapter] && unlockedChapter <= chapter) {
            alert("Answer the questions correctly first!");
            return;
        }
    }

    if (current < pages.length - 1) {
        pages[current].classList.add('flipped');
        current++;
        updateButtons();
    }
};

// Previous button logic
prev.onclick = () => {
    if (current > 0) {
        current--;
        pages[current].classList.remove('flipped');
        updateButtons();
    }
};

updateButtons();