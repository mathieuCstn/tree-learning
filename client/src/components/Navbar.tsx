import React from "react";
import { Link } from "react-router-dom";
import { useAuth } from "../context/AuthContext";

const links = [
  {to: "/dashboard", title: "Dashboard"},
  {to: "/quizzes", title: "Quizzes"},
  {to: "/questions", title: "Questions"},
  {to: "/users", title: "Users list"},
  {to: "/assessment-sessions", title: "My quizzes"}
];

const Navbar = (): JSX.Element => {
  const { user, logoutUser } = useAuth();

  return (
    <nav style={{ padding: "1rem", borderBottom: "1px solid #ccc" }}>
      {links.map(({to, title}, index) => (
        <Link key={index} to={to} style={{ marginRight: "1rem" }}>
          {title}
        </Link>
      ))}
      {user ? (
        <button onClick={logoutUser} style={{ marginLeft: "auto" }}>
          Logout
        </button>
      ) : (
        <Link to="/login">Login</Link>
      )}
    </nav>
  );
};

export default Navbar;
