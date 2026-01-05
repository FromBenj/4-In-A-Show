
export function storePhpFixtures(data) {
    if (!data) {
        return;
    }
    sessionStorage.setItem("fixtures", JSON.stringify(data));
}



