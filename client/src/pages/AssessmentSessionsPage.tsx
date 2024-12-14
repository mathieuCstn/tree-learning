import React, { useEffect, useState } from "react";
import { useAuth } from "../context/AuthContext";
import { fetchUsers, fetchUserDetails, User, AssessmentSession } from "../services/authService";
import { useNavigate } from "react-router-dom";

const AssessmentSessionsPage = (): JSX.Element => {
  const { user: contextUser } = useAuth(); // User depuis le contexte
  const [userDetails, setUserDetails] = useState<User | null>(null);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);

  const navigate = useNavigate();

  useEffect(() => {
    const loadUserDetails = async () => {
      if (!contextUser) {
        setError("Utilisateur non connecté.");
        setLoading(false);
        return;
      }

      try {
        // Étape 1 : Récupérer tous les utilisateurs
        const usersResponse = await fetchUsers();
        const users = usersResponse.member;

        // Étape 2 : Trouver l'utilisateur correspondant dans la liste
        const matchingUser = users.find((user) => user.email === contextUser.username);

        if (!matchingUser) {
          setError("Utilisateur introuvable.");
          setLoading(false);
          return;
        }
        // Étape 3 : Récupérer les détails de l'utilisateur via son ID
        const userDetailsResponse = await fetchUserDetails(matchingUser['@id']);
        setUserDetails(userDetailsResponse); // Ou ajuste selon la structure de l'API
      } catch (err) {
        console.error("Erreur lors du chargement des détails de l'utilisateur :", err);
        setError("Impossible de charger les détails de l'utilisateur.");
      } finally {
        setLoading(false);
      }
    };

    loadUserDetails();
  }, [contextUser]);

  if (loading) return <p>Chargement...</p>;
  if (error) return <p style={{ color: "red" }}>{error}</p>;

  if (!userDetails) return <p>Utilisateur introuvable.</p>;

  // Filtrer les `assessmentSessions` avec les statuts "pending" ou "completed"
  const filteredSessions = userDetails.assessmentSessions.filter(
    (session: AssessmentSession) =>
      ["pending", "completed"].includes(session.status)
  );

  return (
    <div>
      <h1>Sessions d'évaluation</h1>
      <h2>Utilisateur : {userDetails.first_name} {userDetails.last_name}</h2>
      {filteredSessions.length === 0 ? (
        <p>Aucune session avec le statut "pending" ou "completed".</p>
      ) : (
        <table>
          <thead>
            <tr>
              <th>Quiz Title</th>
              <th>Status</th>
              <th>Date de création</th>
            </tr>
          </thead>
          <tbody>
            {filteredSessions.map((session) => (
                <tr key={session["@id"]}>
                <td>{session.quiz.title}</td>
                <td>{session.status}</td>
                <td>{new Date(session.quiz.created_at).toLocaleDateString()}</td>
                <td>
                    <button onClick={() => navigate(`/quiz/${session.quiz["@id"].replace('/api/quizzes/', '')}/?assessmentSessionId=${session["@id"]}`)}>
                    Répondre au quiz
                    </button>
                </td>
                </tr>
            ))}
            </tbody>
        </table>
      )}
    </div>
  );
};

export default AssessmentSessionsPage;
