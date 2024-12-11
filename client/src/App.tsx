import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import { AuthProvider } from "./context/AuthContext";
import Navbar from "./components/Navbar";
import LoginPage from "./pages/LoginPage";
import Dashboard from "./pages/Dashboard";
import QuizzesPage from "./pages/QuizzesPage";
import PrivateRoute from "./components/PrivateRoute";
import QuizDetailPage from "./pages/QuizDetailPage";
import QuestionsPage from "./pages/QuestionsPage";

const App = (): JSX.Element => {
  return (
    <AuthProvider>
      <Router>
        <Navbar />
        <Routes>
          <Route path="/login" element={<LoginPage />} />
          <Route path="/dashboard" element={<PrivateRoute><Dashboard /></PrivateRoute>} />
          <Route path="/quizzes" element={<PrivateRoute><QuizzesPage /></PrivateRoute>} />
          <Route path="/quizzes/:id" element={<PrivateRoute><QuizDetailPage /></PrivateRoute>} />
          <Route path="/questions" element={<PrivateRoute><QuestionsPage /></PrivateRoute>} />
        </Routes>
      </Router>
    </AuthProvider>
  );
};

export default App;
