package controller

import (
	"database/sql"
	"html/template"
	"net/http"
)

func OrderHandler(db *sql.DB) func(http.ResponseWriter, *http.Request) {
	return func(w http.ResponseWriter, r *http.Request) {
		tmpl, err := template.ParseFiles(
			"views/admin/orderlist.html",
			"parts/admin/navbar.html",
			"parts/admin/sidebar.html",
		)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}

		err = tmpl.ExecuteTemplate(w, "order", nil) // GANTI DI SINI
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
		}
	}
}
