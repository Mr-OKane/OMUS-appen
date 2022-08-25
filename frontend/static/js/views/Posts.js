import AbstractView from "./AbstractView.mjs";

export default class Dashboard extends AbstractView {
    constructor() {
        super();
        this.setTitle("Nyheder");
    }
//The server will send the html code to the client.
    async getHtml() {
        return `
                <h1>Nyheder</h1>
                <p>
                 Her kan du se de seneste nyheder.   
                </p>
                <p>
                    <a href="/posts" data-link>Opslag</a>
                </p>
        `;
    }
}