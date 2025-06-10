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

	http.ListenAndServe(":8080", server)
}
