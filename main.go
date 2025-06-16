package main

import (
	"fmt"
	"net/http"

	"github.com/segaak/erpbl/database/database"
	"github.com/segaak/erpbl/routes"
)

func main() {
	// Example usage of the function
	db := database.InitDatabase()
	server := http.NewServeMux()
	fmt.Println("Starting server on :8080")
	routes.MapRoutes(server, db)
	server.Handle("/static/", http.StripPrefix("/static/", http.FileServer(http.Dir("views"))))
	server.Handle("/customer-image/", http.StripPrefix("/customer-image/", http.FileServer(http.Dir("views/customer/images/produk"))))

	http.ListenAndServe(":8080", server)
}
