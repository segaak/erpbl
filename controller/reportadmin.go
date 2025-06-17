package controller

import (
	"database/sql"
	"html/template"
	"net/http"
	"sort"
)

type Report struct {
	ID          int
	Product     string
	Quantity    int
	HargaSatuan int
	Total       int
	Tanggal     string
}

func ReportHandler(db *sql.DB) func(w http.ResponseWriter, r *http.Request) {
	return func(w http.ResponseWriter, r *http.Request) {
		selectedDate := r.URL.Query().Get("date")

		var rows *sql.Rows
		var err error

		// Cek apakah user memilih tanggal
		if selectedDate != "" {
			rows, err = db.Query(`
				SELECT
					p.id, u.nama, pr.nama_produk, p.jumlah, p.harga_satuan, p.subtotal, b.tanggal
				FROM pesanan p
				JOIN pembayaran b ON p.id_pembayaran = b.id
				JOIN produk pr ON p.id_produk = pr.ID_Produk
				JOIN users u ON b.user_id = u.id
				WHERE b.tanggal = ?
			`, selectedDate)
		} else {
			rows, err = db.Query(`
				SELECT 
  p.id,
  pr.nama_produk,
  p.jumlah,
  p.harga_satuan,
  p.subtotal,
  b.tanggal
FROM pesanan p
JOIN produk pr ON p.id_produk = pr.ID_Produk
JOIN pembayaran b ON p.id_pembayaran = b.id
ORDER BY b.tanggal;

			`)
		}

		if err != nil {
			http.Error(w, "Query error: "+err.Error(), http.StatusInternalServerError)
			return
		}
		defer rows.Close()

		var reports []Report
		var total int
		dateMap := make(map[string]bool)

		for rows.Next() {
			var r Report
			err := rows.Scan(&r.ID, &r.Product, &r.Quantity, &r.HargaSatuan, &r.Total, &r.Tanggal)
			if err != nil {
				http.Error(w, "Scan error: "+err.Error(), http.StatusInternalServerError)
				return
			}
			reports = append(reports, r)
			total += r.Total
			dateMap[r.Tanggal] = true
		}

		// Buat slice dari map tanggal (unik)
		var dates []struct{ Tanggal string }
		for t := range dateMap {
			dates = append(dates, struct{ Tanggal string }{t})
		}

		// Urutkan tanggal
		sort.Slice(dates, func(i, j int) bool {
			return dates[i].Tanggal < dates[j].Tanggal
		})

		// Load template
		tmpl, err := template.ParseFiles(
			"views/admin/report.html",
			"parts/admin/navbar.html",
			"parts/admin/sidebar.html",
		)
		if err != nil {
			http.Error(w, "Template error: "+err.Error(), http.StatusInternalServerError)
			return
		}

		// Kirim data ke template
		tmpl.ExecuteTemplate(w, "report", map[string]interface{}{
			"Reports":      reports,
			"Dates":        dates,
			"GrandTotal":   total,
			"SelectedDate": selectedDate,
			"CurrentPath":  r.URL.Path,
		})
	}
}
