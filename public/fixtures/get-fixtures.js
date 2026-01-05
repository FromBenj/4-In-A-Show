import {storePhpFixtures} from "./fixtures-storage.js";

export function getPhpFixtures() {
        console.log("test");

        fetch('/fixtures/sendFixtures.php')
            .then(response => {
                    if (!response.ok) {
                        throw new Error('HTTP error ' + response.status);
                    }
                    return response.json();
                }
            )
            .then(data => {
                console.log(data);
                storePhpFixtures(data);
            })
            .catch(error => console.error('Error:', error));
}

