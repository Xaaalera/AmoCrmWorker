'use strict';

function sends() {
    var text = document.getElementsByTagName("input");
    var formData = new FormData();
    for (var i = 0; i < text.length; i++) {
        var name = text[i].name;
        var value = text[i].value;
        formData.append(name, value);
    }
    return new Promise(function (resolve, reject) {
        fetch('/formworker.php', { method: 'POST', body: formData }).then(function (response) {
            return response.json();
        }).then(function (json) {
            if (!json.leads) {
                return Promise.reject(new Error(json.Error + '  Code Error: ' + json.Code));
            }
            var leads = json.leads['add'][0].id;
            alert('Была создана задача с уникальным идентификатором ' + leads);
        }).catch(function (error) {
            alert(error);
        });
    });
}
