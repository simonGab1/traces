/**
 * @author Andréa Deshaies <andreadeshaies@gmail.com>
 */


export class ImpressionFacture {

    // ATTRIBUTS
    private refBouton: JQuery<HTMLElement> = $('#BtnImpression');



    // Constructeur
    constructor() {
        this.initialiser();
    }

    public initialiser(){
        this.refBouton.on('click', this.imprimer.bind(this));
    }

    public imprimer(){

        var printContents = document.getElementById("sectionImpression").innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

}