import { FormEvent, useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { createAssessmentSession, User, fetchQuizzes, Quiz } from "../services/authService";
import API from "../services/api";

const UserDetailPage = (): JSX.Element => {
    const { id } = useParams();
    const [user, setUser] = useState<User | null>(null);
    const [loading, setLoading] = useState<boolean>(true);
    const [error, setError] = useState<string | null>(null);

    const [quizId, setQuizId] = useState<string>("");
    const [quizzes, setQuizzes] = useState<Quiz[]>([]);

    useEffect(() => {
        const fetchUserDetail = async () => {
            try {
                const { data } = await API.get<User>(`/api/users/${id}`);
                setUser(data);
            } catch (err) {
                console.error("Error fetching user:", err);
                setError("Failed to load user details.");
            } finally {
                setLoading(false);
            }
        };

        fetchUserDetail();
    }, [id]);

    useEffect(() => {
        const loadQuizzes = async () => {
            try {
                const response = await fetchQuizzes();
                setQuizzes(response.member); // Adapte selon la structure de l'API
            } catch (error) {
                console.error("Erreur lors de la récupération des quizzes :", error);
            }
        };

        loadQuizzes();
    }, []);

    const handleSelectChange = (event: React.ChangeEvent<HTMLSelectElement>) => {
        setQuizId(event.target.value);
    };

    const handleSubmit = async (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        if (!user) {
            setError("user variable is null");
            return;
        }

        if (!quizId) {
            setError("Veuillez sélectionner un quiz.");
            return;
        }

        try {
            const addedSession = await createAssessmentSession(user["@id"], quizId);

            const newQuiz = quizzes.find((quiz) => quiz["@id"] === quizId);

            if (newQuiz) {
                const newSession = {
                    quiz: newQuiz,
                };

                setUser((prevUser) =>
                    prevUser
                        ? {
                              ...prevUser,
                              assessmentSessions: [
                                  ...(prevUser.assessmentSessions || []),
                                  newSession,
                              ],
                          }
                        : prevUser
                );
            }

            setQuizId(""); // Réinitialise le champ de sélection
        } catch (error) {
            console.error("Erreur lors de l'ajout du quiz :", error);
            setError("Impossible d'ajouter le quiz.");
        }
    };

    const getAvailableQuizzes = () => {
        if (!user || !user.assessmentSessions) return quizzes;

        const associatedQuizIds = user.assessmentSessions.map((session) => session.quiz["@id"]);
        return quizzes.filter((quiz) => !associatedQuizIds.includes(quiz["@id"]));
    };

    if (loading) return <p>Loading user details...</p>;
    if (error) return <p style={{ color: "red" }}>{error}</p>;

    if (!user) return <p>User not found.</p>;

    return (
        <div>
            <h1>
                {user.first_name} {user.last_name}
            </h1>
            <p>Email: {user.email}</p>

            <h2>Quizzes associés à l'utilisateur</h2>
            {user.assessmentSessions.length === 0 ? (
                <p>Aucun quiz associé à cet utilisateur.</p>
            ) : (
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date de création</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {user.assessmentSessions.map((session) => (
                            <tr key={session.quiz["@id"]}>
                                <td>{session.quiz.title}</td>
                                <td>{session.quiz.description}</td>
                                <td>{new Date(session.quiz.created_at).toLocaleDateString()}</td> 
                                <td>{session.status}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            )}

            <form onSubmit={handleSubmit}>
                <label htmlFor="quiz-dropdown">Sélectionner un quiz :</label>
                <select
                    id="quiz-dropdown"
                    value={quizId}
                    onChange={handleSelectChange}
                >
                    <option value="" disabled>
                        -- Choisir un quiz --
                    </option>
                    {getAvailableQuizzes().map((quiz) => (
                        <option key={quiz["@id"]} value={quiz["@id"]}>
                            {quiz.title}
                        </option>
                    ))}
                </select>
                <button type="submit">Ajouter le quiz</button>
            </form>
        </div>
    );
};

export default UserDetailPage;
