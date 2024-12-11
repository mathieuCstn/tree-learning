import { createLazyFileRoute } from '@tanstack/react-router'

export const Route = createLazyFileRoute('/login')({
  component: Loging,
})

function Loging() {
  return <div className="p-2">Hello from Loging!</div>
}