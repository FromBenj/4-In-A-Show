import {animationAccessibility} from "./function-accessibility.js"
import {tokenCursorStyle} from "./adjust-game-style.js";

export function dotAnimation() {
    const result = animationAccessibility();
    if (result === null) return;
    const playersContainer = document.getElementById("players-container");
    const containerPosition = playersContainer.getBoundingClientRect();
    const containerPositionWidth = containerPosition.width;
    const dot = document.getElementById('moving-dot');
    const dotPosition = dot.getBoundingClientRect();
    const dotPositionWidth = dotPosition.width;
    const leftPosition = setLeftDotPosition();

    const pathX = containerPositionWidth + leftPosition.leftDotX + dotPositionWidth;
    const tl = gsap.timeline();
    // document.body.addEventListener("click", () => {
    tl.to("#moving-dot", {
        x: pathX,
        duration: 2,
        ease: "power2.in"
    })
        .to("#moving-dot", {
            opacity: 0,
            duration: 0.5,
            ease: "power2.in"
        }, 0.25)
        .to("#moving-dot", {
            opacity: 1,
            duration: 0.5,
            ease: "power2.out"
        }, 0.5)
}

export function setLeftDotPosition() {
    const result = animationAccessibility();
    if (result === null) return;
    const rootComputedStyle = getComputedStyle(document.documentElement);
    const rootFontSize = parseFloat(rootComputedStyle.fontSize);

    const dot = document.getElementById('moving-dot');
    const tokenPlayer1 = document.getElementById("token-player1")

    const token1Position = tokenPlayer1.getBoundingClientRect();
    const token1Width = token1Position.width;
    const dotPosition = dot.getBoundingClientRect();
    const dotWidth = dotPosition.width;
    const dotX = 0.5 * rootFontSize + token1Width / 2 - dotWidth / 2;
    const dotY = -1.8 * rootFontSize;
    dot.style.left = dotX + 'px';
    dot.style.top = dotY + 'px';

    return {
        leftDotX: dotX,
        leftDotY: dotY
    };
}

export function setRightDotPosition() {
    const result = animationAccessibility();
    if (result === null) return;
    const playersContainer = document.getElementById("players-container");
    const containerPosition = playersContainer.getBoundingClientRect();
    const dot = document.getElementById('moving-dot');
    const dotPosition = dot.getBoundingClientRect();
    const leftDotPosition = setLeftDotPosition();
    const dotX = containerPosition.width - dotPosition.width - leftDotPosition.leftDotX;
    const dotY = leftDotPosition.leftDotY;
    dot.style.left = dotX.toString() + "px";
    dot.style.top = dotY.toString() + "px";

    return {
        leftDotX: dotX,
        leftDotY: dotY
    };
}

export function customTokenCursor(data) {
    const result = animationAccessibility();
    if (result === null) return;
    document.body.classList.remove("no-cursor");
    const tokenCursor = document.getElementById("token-cursor");
    const playerTokensId = ["token-player1", "token-player2"];
    tokenCursorStyle(data['currentBgColor']);
    const mouseAnimation = () => {
        document.addEventListener('mousemove', (e) => {
            Object.assign(tokenCursor.style, {
                left: (e.pageX) + 'px',
                top: (e.pageY) + 'px',
            })
        });
    }
    document.body.addEventListener('click', (e) => {
        const targetId = e.target.id;
        if (playerTokensId.includes(targetId) && targetId === "token-player" +  data["currentPlayerId"]) {
            document.body.classList.add("no-cursor");
            tokenCursor.classList.remove("d-none");

            mouseAnimation();
        }
    })
}

//shortcut to stop the animation
export function removeCustomCursor() {
    const result = animationAccessibility();
    if (result === null) return;
    let click = 0;
    document.addEventListener('keydown', (e) => {
        if (e.key === 'a' || e.key === 'A') {
            click++;
        }
        console.log(click)
        setTimeout(() => {
            if (click === 2) {
                normalCursor();
            } else {
                click = 0;
            }
        }, 1000)
    })
    const normalCursor = () => {
        console.log("back to normal")
        document.body.cursor = "initial";
        tokenCursor.cursor.display = "none";
    }
}
