package main

import (
	"net/http"

	"github.com/segaak/erpbl/database/database"
	"github.com/segaak/erpbl/routes"
)

func main() {
	// Example usage of the function
	db := database.InitDatabase()

	server := http.NewServeMux()
	routes.MapRoutes(server, db)
	server.Handle("/static/", http.StripPrefix("/static/", http.FileServer(http.Dir("views"))))
	http.ListenAndServe(":8080", server)
}
