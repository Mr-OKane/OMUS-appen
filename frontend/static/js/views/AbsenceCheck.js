import AbstractView from "./AbstractView.mjs";

export default class Dashboard extends AbstractView {
    constructor() {
        super();
        this.setTitle("Fravær");
    }
//The server will send the html code to the client.
    async getHtml() {
        return `
                <h1>Fravær</h1>
                <p>
                 Her kan der tjekkes fravær.    
                </p>
                <p>
                    <a href="/posts" data-link>Opslag</a>
                </p>
        `;
    }
}