//Frontend entry point
import Dashboard from "./views/Dashboard.js";
import Posts from "./views/Posts.js";
import Settings from "./views/Settings.js";
import AbsenceCheck from "./views/AbsenceCheck.js";
import Notes from "./views/Notes.js";
import About from "./views/About.js";
import Messages from "./views/Messages.js";

const navigateTo = url => {
    history.pushState(null, null, url); //We add an entry to the browsers history.
    router();
}; 

const router = async () => { //We use async/await to make sure that the code is executed in the correct order.
    const routes = [
        { path: "/", view: Dashboard },
        { path: "/news", view: Posts }, //We can add as many routes as we want.,
        { path: "/notes", view: Notes },
        { path: "/absence-check", view: AbsenceCheck },
        { path: "/settings", view: Settings },
        { path: "/messages", view: Messages },
        { path: "/about", view: About }

    ];
    //Test each route for potential match
    const potentialMatches = routes.map(route => {
        return{
            route: route, 
            isMatch: location.pathname === route.path 
        }
    }); 
    //We map the routes to potential matches.
    
    let match = potentialMatches.find(potentialMatches => potentialMatches.isMatch);
    //If there is no match, then we set it to default. 

    if (!match) {
        match = {
            route: route[0], 
            isMatch: true
        };

    }

    const view = new match.route.view();
    // Create a new instance of the view

    document.querySelector("#app").innerHTML = await view.getHtml();

}; 

window.addEventListener("popstate", router);

//Make sure that the page doesn't refresh. Basically prevent the default behaviour and navigate to the natural href.
document.addEventListener("DOMContentLoaded", () => {
    document.body.addEventListener("click", e =>{
        if (e.target.matches("[data-link]")) {
            e.preventDefault();
            navigateTo(e.target.href);
        }
    });
    router();

});
    