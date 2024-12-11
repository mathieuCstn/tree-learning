import React from "react";
import { useAuth } from "../context/AuthContext";

const Dashboard = (): JSX.Element => {
  const { user, logoutUser } = useAuth();

  return (
    <div>
      <h1>Welcome, {user?.username}</h1>
      <button onClick={logoutUser}>Logout</button>
    </div>
  );
};

export default Dashboard;
