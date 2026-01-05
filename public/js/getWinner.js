export function receiveWinner() {
    fetch('/api/check-winner', {
        method: 'GET',
        headers: {'Content-Type': 'application/json'},
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not OK');
            }
            return response.json();
        })
        .then(data => {
            if(data["getWinner"] === "yes") {
                alert("T'as gagné !")
            }
            console.log(data["getWinner"]);
        })
        .catch(error => {
            console.error('Fetch failed:', error);
        });
}
