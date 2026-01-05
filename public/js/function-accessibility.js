export function animationAccessibility() {
    const body = document.body;
    const routeName = body.dataset.route;

    return routeName === "home" ? null : routeName;
}
