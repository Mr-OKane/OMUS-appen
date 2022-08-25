import AbstractView from "./AbstractView.mjs";

export default class Dashboard extends AbstractView {
    constructor() {
        super();
        this.setTitle("Noder");
    }
//The server will send the html code to the client.
    async getHtml() {
        return `
                <h1>Noder</h1>
                <p>
                 Her kan du se dine noder og downloade dem.    
                </p>
                <p>
                    <a href="/posts" data-link>Opslag</a>
                </p>
        `;
    }
}