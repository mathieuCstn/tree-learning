import React from "react";
import { Navigate } from "react-router-dom";
import { useAuth } from "../context/AuthContext";

interface PrivateRouteProps {
  children: JSX.Element;
  roles?: string[]; // Liste des rôles autorisés
}

const PrivateRoute = ({ children, roles }: PrivateRouteProps): JSX.Element => {
  const { user } = useAuth();

  // Si l'utilisateur n'est pas connecté
  if (!user) {
    return <Navigate to="/login" />;
  }

  // Vérifie si l'utilisateur a au moins un rôle autorisé
  if (roles && !roles.some((role) => user.roles.includes(role))) {
    return("Vous n'êtes pas autorisé à voir cette page");
  }

  // Autoriser l'accès si aucune restriction ou rôle correct
  return children;
};

export default PrivateRoute;
