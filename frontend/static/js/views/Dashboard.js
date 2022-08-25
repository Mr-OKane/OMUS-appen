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
                <iframe src="https://calendar.google.com/calendar/embed?height=500&wkst=1&bgcolor=%237986CB&ctz=Europe%2FCopenhagen&showTitle=0&hl=da&src=ZW1pbG9rYW5lMTRAZ21haWwuY29t&src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&src=ZW4uZGFuaXNoI2hvbGlkYXlAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&color=%23039BE5&color=%2333B679&color=%230B8043" style="border:solid 1px #777" width="500" height="500" frameborder="1" scrolling="no"></iframe>
        `;
    }
}