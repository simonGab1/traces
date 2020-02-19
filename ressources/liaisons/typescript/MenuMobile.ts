/**
 * @author Simon-Gabriel Côté-Poulin <simon_gab@outlook.com>
 */


export class MenuMobile {

    // ATTRIBUTS
    private menu: JQuery<HTMLElement> = $("#hamburger");
    private fermerMenu: JQuery<HTMLElement> = $("#fermer");


    // Constructeur
    constructor() {

        this.menu.on("click", this.myFunction.bind(this));
        this.fermerMenu.on("click", this.fermer.bind(this));

    }

    public myFunction() {
        let x = document.getElementById("myLinks");
        if (x.style.display === "block") {
            x.style.display = "none";
        } else {
            x.style.display = "block";
        }

        let ham = document.getElementById("hamburger");
        ham.classList.add("visuallyhidden");

        let close = document.getElementById("fermer");
        close.classList.remove("visuallyhidden");
    }

    public fermer() {
        let x = document.getElementById("myLinks");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }

        let ham = document.getElementById("hamburger");
        ham.classList.remove("visuallyhidden");

        let close = document.getElementById("fermer");
        close.classList.add("visuallyhidden");

    }
}