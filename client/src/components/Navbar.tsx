import React from "react";
import { Link } from "react-router-dom";
import { useAuth } from "../context/AuthContext";

const Navbar = (): JSX.Element => {
  const { user, logoutUser } = useAuth();

  return (
    <nav style={{ padding: "1rem", borderBottom: "1px solid #ccc" }}>
      <Link to="/dashboard" style={{ marginRight: "1rem" }}>
        Dashboard
      </Link>
      <Link to="/quizzes" style={{ marginRight: "1rem" }}>
        Quizzes
      </Link>
      <Link to="/questions" style={{ marginRight: "1rem" }}>
        Questions
      </Link>
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
