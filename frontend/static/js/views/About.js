import AbstractView from "./AbstractView.mjs";

export default class Dashboard extends AbstractView {
    constructor() {
        super();
        this.setTitle("Om os");
    }
//The server will send the html code to the client.
    async getHtml() {
        return `
                <h1>Om os</h1>
                <p>
                    <font size="4">
                        OMUS er et symfoniorkester i Odense Musikskole. Vi har i øjeblikket x medlemmer i orkestret, og
                        vi er et relativt nyt orkester. 
                        Det er en sammensætning af to orkestre, der har arbejdet i samarbejde med hinanden igennem årene. 
                        <br>
                        De to orkestre var: Helt blæst og Junior-Strygerne. 
                        Efter mange år med samarbejde besluttede vi at lave et ny symfoniorkester, der hedder OMUS.
                        <br>
                        Vi spiller alt fra Wagner til Hans Zimmer. Orkestrets repetoire bestemmes delvist af eleverne selv, og vi holder møder hver måned, hvor der besluttes forskellige ting. 
                        </font>
                </p>
        `;
    }
}