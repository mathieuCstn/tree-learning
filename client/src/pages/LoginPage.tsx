import React, { useState } from "react";
import { useAuth } from "../context/AuthContext";
import { login } from "../services/authService";
import { useNavigate } from "react-router-dom";

const LoginPage = (): JSX.Element => {
  const [credentials, setCredentials] = useState({ email: "", password: "" });
  const [error, setError] = useState<string | null>(null);
  const { loginUser } = useAuth();
  const navigate = useNavigate();

  const handleSubmit = async (e: React.FormEvent): Promise<void> => {
    e.preventDefault();
    try {
      const user = await login(credentials);
      loginUser(user);
      navigate("/dashboard");
    } catch (err) {
      console.error("Error fetching user:", err);
      setError("Invalid credentials");
    }
  };

  return (
    <div>
      <h1>Login</h1>
      {error && <p style={{ color: "red" }}>{error}</p>}
      <form onSubmit={handleSubmit}>
        <input
            type="email"
            placeholder="Email"
            value={credentials.email}
            onChange={(e) => setCredentials({ ...credentials, email: e.target.value })}
        />
        <input
            type="password"
            placeholder="Password"
            value={credentials.password}
            onChange={(e) => setCredentials({ ...credentials, password: e.target.value })}
        />
        <button type="submit">Login</button>
      </form>
    </div>
  );
};

export default LoginPage;
