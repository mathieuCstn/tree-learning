import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { fetchQuizzes } from "../services/authService";

interface Quiz {
  "@id": string;
  "@type": string;
  title: string;
  description: string;
  created_at: string;
  questions: string[];
}

const QuizzesPage = (): JSX.Element => {
  const [quizzes, setQuizzes] = useState<Quiz[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);
  const navigate = useNavigate();

  useEffect(() => {
    const getQuizzes = async () => {
      try {
        const data = await fetchQuizzes();
        console.log("API Response:", data); // Inspecter la réponse
        if (data && Array.isArray(data.member)) {
          setQuizzes(data.member); // Utiliser le tableau "member" de la réponse
        } else {
          console.error("Invalid API response format:", data);
          setError("Failed to load quizzes.");
        }
      } catch (err) {
        console.error("Error fetching quizzes:", err);
        setError("Failed to load quizzes. Please try again later.");
      } finally {
        setLoading(false);
      }
    };

    getQuizzes();
  }, []);

  if (loading) return <p>Loading quizzes...</p>;
  if (error) return <p style={{ color: "red" }}>{error}</p>;

  return (
    <div>
      <h1>Available Quizzes</h1>
      {quizzes.length > 0 ? (
        <ul style={{ listStyle: "none", padding: 0 }}>
          {quizzes.map((quiz) => (
            <li key={quiz["@id"]} style={{ marginBottom: "1rem", padding: "1rem", border: "1px solid #ddd" }}>
              <h2>{quiz.title}</h2>
              <p>{quiz.description}</p>
              <p><strong>Questions:</strong> {quiz.questions.length}</p>
              <p><strong>Created at:</strong> {new Date(quiz.created_at).toLocaleDateString()}</p>
              <button onClick={() => navigate(`/quizzes/${quiz["@id"].split("/").pop()}`)}>Show Details</button>
            </li>
          ))}
        </ul>
      ) : (
        <p>No quizzes available at the moment.</p>
      )}
    </div>
  );
};

export default QuizzesPage;
