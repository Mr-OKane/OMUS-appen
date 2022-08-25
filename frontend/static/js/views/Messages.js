import AbstractView from "./AbstractView.mjs";

export default class Dashboard extends AbstractView {
    constructor() {
        super();
        this.setTitle("Beskeder");
    }
//The server will send the html code to the client.
    async getHtml() {
        return `
                <h1>Chat</h1>
                <p>
                    Her kan du skrive med andre i orkestret. 
                </p>
        `;
    }
}