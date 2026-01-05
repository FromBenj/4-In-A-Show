export function winnerAnimation() {
    document.body.addEventListener('click', () => {
        gsap.timeline()
            .from("#splash", {
                scale: 0,
                opacity: 0,
                duration: 0.3,
                ease: "power3.out"
            })
            .to("#splash", {
                scale: 1.15,
                duration: 0.1,
                ease: "power2.out"
            })
            .to("#splash", {
                scale: 1,
                duration: 0.1,
                ease: "bounce.out",
                repeat: 3,
                yoyo: true
            });
    })
}

