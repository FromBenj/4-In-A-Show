export function applyFixtures() {
    const phpFixtures = JSON.parse(sessionStorage.getItem("fixtures"));
    // phpFixtures.forEach((data, index) => {
    //     // fetchFixtures();
    //     console.log(data);
    // });
    console.log(phpFixtures);
    return phpFixtures;
}



// const fetchFixtures = (col, row) => {
//     fetch('../fixtures/addTokenFixtures.php', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify({})
//     })
//         .then(res => res.json())
//         .then(data => {
//             console.log(data);
//
//         })
//         .catch(err => console.error(err));
// }
//
// fetchFixtures();
