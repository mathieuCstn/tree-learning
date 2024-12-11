import React, { createContext, useContext, useState, useEffect, ReactNode } from "react";
import { getCurrentUser, logout, User } from "../services/authService";

interface AuthContextType {
  user: User | null;
  loginUser: (user: User) => void;
  logoutUser: () => void;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export const AuthProvider = ({ children }: { children: ReactNode }): JSX.Element => {
  const [user, setUser] = useState<User | null>(getCurrentUser());

  const loginUser = (userData: User): void => {
    setUser(userData);
  };

  const logoutUser = (): void => {
    logout();
    setUser(null);
  };

  useEffect(() => {
    setUser(getCurrentUser());
  }, []);

  return (
    <AuthContext.Provider value={{ user, loginUser, logoutUser }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = (): AuthContextType => {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error("useAuth must be used within an AuthProvider");
  }
  return context;
};
