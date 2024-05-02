import {gsap} from "./gsap/gsap";
import {ScrollTrigger} from "./gsap/ScrollTrigger";
import {renderBlock} from "./functions";

gsap.registerPlugin(ScrollTrigger);

const initializeBlock = block => {

}

renderBlock('type', initializeBlock)
