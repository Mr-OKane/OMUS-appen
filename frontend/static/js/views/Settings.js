import AbstractView from "./AbstractView.mjs";

export default class Dashboard extends AbstractView {
    constructor() {
        super();
        this.setTitle("Indstillinger");
    }
//The server will send the html code to the client.
    async getHtml() {
        return `
                <h1>Indstillnger</h1>
                <p>
                 Du kan ændre dine indstillinger her.   
                </p>
                
        `;
    }
}

//<p>
//                    <a href="/posts" data-link>Opslag</a>
//                </p>