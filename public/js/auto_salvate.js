function apri(event){
    box= event.currentTarget;
    console.log(box);

}

function onJson(json){
    console.log(json);
    galleria= document.querySelector("#galleria");
    if(json.length==0){
        const messaggio= document.createElement('h1');
        messaggio.textContent= "Nessun elemento salvato!";
        messaggio.classList.add("error");
        galleria.appendChild(messaggio);
    }else{
        for(let result of json){
            const box= document.createElement("a");
            box.classList.add("box");
            const img= document.createElement("img");
            const modello= document.createElement("h1");
            const marca= document.createElement("h1");
            const anno= document.createElement("h1");
            img.src= result.img;
            marca.textContent= result.marca;
            modello.textContent= result.modello;
            anno.textContent= result.anno;
            box.appendChild(img);
            box.appendChild(marca);
            box.appendChild(modello);
            box.appendChild(anno);
            URL= BASE_URL + "specifiche_auto/" + encodeURIComponent(anno.textContent) + "/" + encodeURIComponent(marca.textContent) + "/" + encodeURIComponent(modello.textContent);
            box.href= URL;
            galleria.appendChild(box);
        }
    }
}

function onResponse(response){
    return response.json();
}

function carica(){
    fetch(BASE_URL + "carica_auto_salvate").then(onResponse).then(onJson);
}

carica();