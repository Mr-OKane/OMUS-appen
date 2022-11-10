import { useState } from "react";

import { close, logo, menu } from "../assets";
import { navLinks } from "../constants";

const Navbar = () => {
  const [toggle, setToggle] = useState(false);

  return (
    <nav className="w-full flex py-6 justify-between items-center navbar">
      <img
        src={logo}
        alt="OMUS"
        className="mx-auto flex justify-center items-center place-content-center"
      />
      <ul className="list-none md:flex hidden justify-end items center flex-1">
        {navLinks.map((nav, index) => (
          <li
            key={nav.id}
            className={`font-poppins font-normal cursor-pointer text[16px] ${
              index === navLinks.length - 1 ? "mr-0" : "mr-10"
            } text-white`}
          >
            <a href={"#${nav.id}"}>{nav.title}</a>
          </li>
        ))}
      </ul>
      <div className="md:hidden flex flex-1 justify-end items-center">
        <img
          src={toggle ? close : menu}
          alt="menu"
          className="w-[28px] h-[28px] object-contain"
          onClick={() => setToggle((prev) => !prev)}
        />
        <img src={logo} alt="OMUS" className="hidden md:" />
        <div
          className={`${
            !toggle ? "hidden" : "flex"
          } p-6 bg-primary absolute top-20 right-0 mx-4 my-2 min-w-[140px] rounded-xl sidebar`}
        >
          <ul className="list-none flex justify-end items-center flex-1 flex-col">
            {navLinks.map((nav, index) => (
              <li
                key={nav.id}
                className={`font-poppins font-normal cursor-pointer text[16px] ${
                  index === navLinks.length - 1 ? "mb-0" : "mb-10"
                } text-white`}
              >
                <a href={"#${nav.id}"}>{nav.title}</a>
              </li>
            ))}
          </ul>
        </div>
      </div>
    </nav>
  );
};

export default Navbar;
