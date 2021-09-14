let form = document.getElementById('form');
let go = document.getElementById('go');
let user = document.getElementById('userHealth');
let monster = document.getElementById('monsterHealth');
let attack = document.getElementById('attack');
let spell = document.getElementById('spell');
let type = '/api/attack';
let course = document.getElementById("course");

attack.addEventListener('click', function (){
    type = '/api/attack';
});

spell.addEventListener('click', function (){
    type = '/api/spell';
});

form.addEventListener('submit', e => {
    e.preventDefault();

    let fd = new FormData(form);
    fd.append('<?= Yii::$app->request->csrfParam ?>', '<?= Yii::$app->request->csrfToken ?>');

    fetch(type, {
        method: 'POST',
        body : fd
    })
        .then(request => {
            if(request.ok)
                return request.json();
            else
                console.log("erreur" + request.status)
        })
        .then(data => {
            user.innerHTML = data[0];
            monster.innerHTML = data[1];
            console.log(data);

            course.classList.add("alert", "alert-secondary", "m-3", "text-center");
            course.innerHTML = 'Vous avez fait ' + data[2] + ' de dégât' + '<br>' + 'vous avez reçu ' + data[3] + ' de dégât' + '<br>' + data[4];

            let message = document.createElement("div");
            let div = document.getElementById("bottom");
            let button = document.createElement('a');

            if(data[0] === 0){
                message.classList.add("alert", "alert-danger", "m-3", "text-center");
                message.appendChild(document.createTextNode("Vous êtes mort"));
                document.getElementById("labAttack").remove();
                document.getElementById("labSpell").remove();
                spell.remove();
                attack.remove();
                go.remove();
                div.classList.add("text-center");
                div.appendChild(button);
                button.innerHTML = "Continuer";
                button.classList.add("btn", "btn-danger");
                button.href = "/";
            }
            else if(data[1] === 0) {
                document.getElementById("labAttack").remove();
                document.getElementById("labSpell").remove();
                spell.remove();
                attack.remove();
                go.remove();
                div.classList.add("text-center");
                div.appendChild(button);
                button.innerHTML = "Continuer";
                button.classList.add("btn", "btn-success");
                button.href = "/game/";
                message.classList.add("alert", "alert-success", "m-3", "text-center");
                message.appendChild(document.createTextNode("Vous avez vaincu!"));
            }
            form.appendChild(message);
        })
})