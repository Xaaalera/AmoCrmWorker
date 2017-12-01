'use strict';
function sends() {
    let text = document.getElementsByTagName("input");
    let formData = new FormData();
    for (let i = 0; i < text.length; i++) {
        let name = text[i].name;
        let value = text[i].value;
        formData.append(name, value);
    }
    return new Promise ((resolve, reject) => {
            fetch('/formworker.php', {method: 'POST', body: formData})
.then(function (response) {
        return response.json();
    }).then(function (json) {
        if (!(json.leads)) {
            return Promise.reject(new Error(`${json.Error}  Code Error: ${json.Code}`))
        }
        let leads = json.leads['add'][0].id;
        alert(`Была создана задача с уникальным идентификатором ${leads}`)

    })
        .catch(function (error) {
            alert(error);
        });
});

}

