import AbstractView from "./AbstractView.mjs";

export default class Dashboard extends AbstractView {
    constructor() {
        super();
        this.setTitle("Kageliste");
    }
//The server will send the html code to the client.
    async getHtml() {
        return `
                <h1>Kageliste</h1>
                <p>
                 Kage er en vigtig del af OMUS. Her kan du se, hvem den næste der skal have kage med er.   
                </p>
                <p>
                    <a href="/posts" data-link>Opslag</a>
                </p>
        `;
    }
}