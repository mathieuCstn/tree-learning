import { useEffect, useState } from "react";
import { fetchUsers, User } from "../services/authService";
import { useNavigate } from "react-router-dom";

const UsersPage = () => {
    const [users, setUsers] = useState<User[]>([]);
      const [loading, setLoading] = useState<boolean>(true);
    const [error, setError] = useState<string | null>(null);
    const navigate = useNavigate();

    useEffect(() => {
        const getUsers = async () => {
            try {
                const data = await fetchUsers();
                if(data && Array.isArray(data.member)) {
                    setUsers(data.member);
                }
            } catch (err) {
                console.error("Error fetching users:", err);
                setError("Failed to load users. Please try again later.");
            } finally {
                setLoading(false);
            }
        };

        getUsers();
    }, []);
    
    if (loading) return <p>Loading users list...</p>;
    if (error) return <p style={{ color: "red" }}>{error}</p>;

    return (
        <>
            <h1>Users list</h1>
            {users.length > 0 ? (
                <ul style={{ listStyle: "none", padding: 0 }}>
                    {users.map((user) => (
                        <li key={user["@id"]} style={{ marginBottom: "1rem", padding: "1rem", border: "1px solid #ddd" }}>
                        <h2>{user.first_name} {user.last_name}</h2>
                        <p>Email: {user.email}</p>
                        <p>Degrees</p>
                        {user.degrees ? (
                            <ul>
                                {user.degrees.map((degree) => (
                                    <li key={degree["@id"]}>{degree.name}</li>
                                ))}
                            </ul>
                        ) : null}
                        <button onClick={() => navigate(`/users/${user["@id"].split("/").pop()}`)}>Show Details</button>
                        </li>
                    ))}
                </ul>
            ) : (
                <p>No users available at the moment.</p>
            )}
        </>
    )
}

export default UsersPage;