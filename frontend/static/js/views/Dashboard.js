import AbstractView from "./AbstractView.mjs";

export default class Dashboard extends AbstractView {
    constructor() {
        super();
        this.setTitle("Hjem");
    }
//The server will send the html code to the client.
    async getHtml() {
        return `
                <h1>Nyheder</h1>
                <p>
                    <font size="5">
                        Velkommen tilbage 
                        </font>
                </p>
                
        `;
    }
}