package controller

import (
	"database/sql"
	"html/template"
	"net/http"
)

func DashboardHandler(db *sql.DB) func(http.ResponseWriter, *http.Request) {
	return func(w http.ResponseWriter, r *http.Request) {
		tmpl, err := template.ParseFiles(
			"views/admin/admindashboard.html",
			"parts/admin/navbar.html",
			"parts/admin/sidebar.html",
		)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}

		// Data bisa diisi dari db kalau kamu mau
		err = tmpl.ExecuteTemplate(w, "dashboard", map[string]interface{}{
	"CurrentPath": r.URL.Path,
})
	}
}
