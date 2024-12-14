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
import UsersPage from "./pages/UsersPage";
import UserDetailPage from "./pages/UserDetailPage";
import AssessmentSessionsPage from "./pages/AssessmentSessionsPage";
import QuizPage from "./pages/QuizPage";

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
          <Route path="/users" element={<PrivateRoute roles={["ROLE_ADMIN"]}><UsersPage /></PrivateRoute>} />
          <Route path="/users/:id" element={<PrivateRoute><UserDetailPage /></PrivateRoute>} />
          <Route path="/assessment-sessions" element={<PrivateRoute><AssessmentSessionsPage /></PrivateRoute>} />
          <Route path="/quiz/:quizId" element={<PrivateRoute><QuizPage /></PrivateRoute>} />
        </Routes>
      </Router>
    </AuthProvider>
  );
};

export default App;
