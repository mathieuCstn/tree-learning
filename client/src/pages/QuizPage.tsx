import React, { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import { Quiz, Question, Choice, fetchQuizById, saveSessionQuizChoice } from "../services/authService";

const QuizPage = (): JSX.Element => {
  const { quizId } = useParams<{ quizId: string }>(); // Paramètre de l'URL
  const navigate = useNavigate();
  const [quiz, setQuiz] = useState<Quiz | null>(null);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);
  const [answers, setAnswers] = useState<{ [questionId: string]: string }>({});

  // Remplace par la méthode qui permet d'obtenir l'ID de session en cours
  const query = new URLSearchParams(location.search);
  const sessionId = query.get("assessmentSessionId"); // Exemple d'ID de session pour les réponses


  useEffect(() => {
    const loadQuiz = async () => {
      if (!quizId) {
        setError("ID du quiz manquant.");
        setLoading(false);
        return;
      }

      try {
        const quizData = await fetchQuizById(quizId); // Charger le quiz par ID
        if (!quizData) {
          setError("Quiz introuvable.");
        } else {
          setQuiz(quizData);
        }
      } catch (err) {
        console.error("Erreur lors du chargement du quiz :", err);
        setError("Impossible de charger le quiz.");
      } finally {
        setLoading(false);
      }
    };

    loadQuiz();
  }, [quizId]);

  const handleAnswerChange = async (choiceId: string) => {
    setAnswers((prev) => ({ ...prev, choiceId }));

    try {
      // Sauvegarder la réponse côté backend
      await saveSessionQuizChoice(sessionId, choiceId);
      console.log(`Réponse sauvegardée : Choix ${choiceId}`);
    } catch (err) {
      console.error("Erreur lors de la sauvegarde de la réponse :", err);
      setError("Impossible de sauvegarder votre réponse.");
    }
  };

  const handleSubmit = () => {
    alert("Quiz terminé !");
    navigate("/assessment-sessions"); // Redirection après soumission
  };

  if (loading) return <p>Chargement du quiz...</p>;
  if (error) return <p style={{ color: "red" }}>{error}</p>;

  if (!quiz) return <p>Quiz introuvable.</p>;

  return (
    <div>
      <h1>Quiz : {quiz.title}</h1>
      <p>{quiz.description}</p>
      <form>
        {quiz.questions?.map((question: Question) => (
          <div key={question["@id"]}>
            <h3>{question.title}</h3>
            {question.choices.map((choice: Choice) => (
              <div key={choice["@id"]}>
                <label>
                  <input
                    type="radio"
                    name={question["@id"]}
                    value={choice["@id"]}
                    checked={answers[question["@id"]] === choice["@id"]}
                    onChange={() => handleAnswerChange(choice["@id"])}
                  />
                  {choice.content}
                </label>
              </div>
            ))}
          </div>
        ))}
        <button type="button" onClick={handleSubmit}>
          Terminer le quiz
        </button>
      </form>
    </div>
  );
};

export default QuizPage;
