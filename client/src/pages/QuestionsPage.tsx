import { useEffect, useState } from "react";
import { fetchQuestions, Question } from "../services/authService";

const QuestionsPage = () => {
    const [questions, setQuestions] = useState<Question[]>([]);
      const [loading, setLoading] = useState<boolean>(true);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        const getQuestions = async () => {
            try {
                const data = await fetchQuestions();
                if(data && Array.isArray(data.member)) {
                    setQuestions(data.member);
                }
            } catch (err) {
                console.error("Error fetching questions:", err);
                setError("Failed to load questions. Please try again later.");
            } finally {
                setLoading(false);
            }
        };

        getQuestions();
    }, []);
    
    if (loading) return <p>Loading questions...</p>;
    if (error) return <p style={{ color: "red" }}>{error}</p>;

    return (
        <>
            <h1>Available Questions</h1>
            {questions.length > 0 ? (
                <form>
                    <ul style={{ listStyle: "none", padding: 0 }}>
                        {questions.map((question) => (
                            <li key={question["@id"]} style={{ marginBottom: "1rem", padding: "1rem", border: "1px solid #ddd" }}>
                                <h2>{question.title}</h2>
                                <ul>
                                    {question.choices.map((choice) => (
                                        <li key={choice["@id"]}>
                                            <input type="checkbox" id={choice["@id"]} />
                                            <label htmlFor={choice["@id"]}>{choice.content}</label>
                                        </li>
                                    ))}
                                </ul>
                            </li>
                        ))}
                    </ul>
                    <input type="submit" value="Valider et soumettre le quiz" />
                </form>
            ) : (
                <p>No questions available at the moment.</p>
            )}
        </>
    )
}

export default QuestionsPage;