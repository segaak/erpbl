package controller

import (
	"database/sql"
	"encoding/json"
	"html/template"
	"net/http"
	"strconv"
	"time"
)

// Fungsi untuk encode ke JSON agar bisa dipakai di JS
func toJSON(v interface{}) template.JS {
	jsonBytes, _ := json.Marshal(v)
	return template.JS(jsonBytes)
}

// Struct untuk monthly revenue data
type MonthlyRevenueData struct {
	Sales  []int `json:"sales"`
	Profit []int `json:"profit"`
}

func OwnerDashboardHandler(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		// 1. Total customer dengan role 'customer'
		var totalCustomer int
		err := db.QueryRow("SELECT COUNT(*) FROM users WHERE roles = 'customer'").Scan(&totalCustomer)
		if err != nil {
			totalCustomer = 0
		}

		// 2. Repeated customers (customers yang pernah pesan lebih dari 1 kali)
		var repeatedCustomers int
		err = db.QueryRow(`
			SELECT COUNT(DISTINCT user_id) 
			FROM pesanan 
			WHERE user_id IN (
				SELECT user_id 
				FROM pesanan 
				GROUP BY user_id 
				HAVING COUNT(*) > 1
			)
		`).Scan(&repeatedCustomers)
		if err != nil {
			repeatedCustomers = 0
		}

		// 3. Total pesanan dari tabel pesanan
		var totalOrder int
		err = db.QueryRow("SELECT COUNT(*) FROM pesanan").Scan(&totalOrder)
		if err != nil {
			totalOrder = 0
		}

		// 4. Total penjualan minggu ini & minggu lalu untuk perbandingan
		now := time.Now()
		weekday := int(now.Weekday())
		if weekday == 0 {
			weekday = 7 // Minggu dianggap hari ke-7
		}
		thisWeekStart := now.AddDate(0, 0, -weekday+1)
		lastWeekStart := thisWeekStart.AddDate(0, 0, -7)
		lastWeekEnd := thisWeekStart

		var totalSalesThisWeek, totalSalesLastWeek float64
		err = db.QueryRow(`
			SELECT COALESCE(SUM(total), 0) 
			FROM pembayaran 
			WHERE tanggal >= ? AND tanggal <= ?
		`, thisWeekStart.Format("2006-01-02"), now.Format("2006-01-02")).Scan(&totalSalesThisWeek)
		if err != nil {
			totalSalesThisWeek = 0
		}

		err = db.QueryRow(`
			SELECT COALESCE(SUM(total), 0) 
			FROM pembayaran 
			WHERE tanggal >= ? AND tanggal < ?
		`, lastWeekStart.Format("2006-01-02"), lastWeekEnd.Format("2006-01-02")).Scan(&totalSalesLastWeek)
		if err != nil {
			totalSalesLastWeek = 0
		}

		// 5. Persentase naik/turun penjualan
		var salesChange float64
		if totalSalesLastWeek > 0 {
			salesChange = ((totalSalesThisWeek - totalSalesLastWeek) / totalSalesLastWeek) * 100
		}

		// 6. Sales analytics per tahun
		rows, err := db.Query(`
			SELECT YEAR(tanggal) as year, SUM(total) as total
			FROM pembayaran 
			WHERE tanggal >= '2020-01-01'
			GROUP BY YEAR(tanggal) 
			ORDER BY YEAR(tanggal)
		`)
		var years []string
		var yearlyValues []float64
		if err == nil {
			defer rows.Close()
			for rows.Next() {
				var year int
				var value float64
				err := rows.Scan(&year, &value)
				if err == nil {
					years = append(years, strconv.Itoa(year))
					yearlyValues = append(yearlyValues, value)
				}
			}
		}

		// 7. Monthly revenue data untuk dropdown (contoh data untuk beberapa bulan)
		monthlyRevenue := make(map[string]MonthlyRevenueData)

		// Query untuk setiap bulan (contoh untuk tahun current)
		currentYear := now.Year()
		for month := 1; month <= 12; month++ {
			monthStart := time.Date(currentYear, time.Month(month), 1, 0, 0, 0, 0, time.UTC)
			monthEnd := monthStart.AddDate(0, 1, -1)

			// Query sales dan profit per hari dalam bulan
			dailyRows, err := db.Query(`
				SELECT 
					DAY(tanggal) as day,
					SUM(total) as daily_sales,
					SUM(total * 0.3) as daily_profit  -- Asumsi profit 30% dari sales
				FROM pembayaran 
				WHERE tanggal >= ? AND tanggal <= ?
				GROUP BY DAY(tanggal)
				ORDER BY DAY(tanggal)
			`, monthStart.Format("2006-01-02"), monthEnd.Format("2006-01-02"))

			var salesData []int
			var profitData []int

			if err == nil {
				defer dailyRows.Close()

				// Initialize dengan 0 untuk semua hari
				for i := 0; i < 31; i++ {
					salesData = append(salesData, 0)
					profitData = append(profitData, 0)
				}

				// Fill dengan data actual
				for dailyRows.Next() {
					var day int
					var sales, profit float64
					err := dailyRows.Scan(&day, &sales, &profit)
					if err == nil && day <= len(salesData) {
						salesData[day-1] = int(sales / 1000) // Convert to thousands
						profitData[day-1] = int(profit / 1000)
					}
				}

				// Ambil sample 12 data points untuk chart
				step := len(salesData) / 12
				if step == 0 {
					step = 1
				}

				var sampledSales []int
				var sampledProfit []int
				for i := 0; i < 12; i++ {
					idx := i * step
					if idx < len(salesData) {
						sampledSales = append(sampledSales, salesData[idx])
						sampledProfit = append(sampledProfit, profitData[idx])
					} else {
						sampledSales = append(sampledSales, 0)
						sampledProfit = append(sampledProfit, 0)
					}
				}

				monthlyRevenue[strconv.Itoa(month)] = MonthlyRevenueData{
					Sales:  sampledSales,
					Profit: sampledProfit,
				}
			} else {
				// Fallback data jika query gagal
				monthlyRevenue[strconv.Itoa(month)] = MonthlyRevenueData{
					Sales:  []int{20, 40, 30, 35, 50, 60, 85, 60, 65, 55, 58, 40},
					Profit: []int{15, 30, 22, 25, 35, 45, 65, 45, 48, 40, 43, 30},
				}
			}
		}

		// Template function
		tmpl := template.New("dashboard").Funcs(template.FuncMap{
			"toJson": toJSON,
		})

		tmpl, err = tmpl.ParseFiles(
			"views/owner/ownerdashboard.html",
			"parts/owner/navbar.html",
			"parts/owner/sidebar.html",
		)
		if err != nil {
			http.Error(w, "Template parsing error: "+err.Error(), http.StatusInternalServerError)
			return
		}

		// Execute template dengan data
		data := map[string]interface{}{
			"TotalCustomer":     totalCustomer,
			"RepeatedCustomers": repeatedCustomers,
			"TotalOrder":        totalOrder,
			"TotalSales":        totalSalesThisWeek,
			"SalesChange":       salesChange,
			"SalesChangeIsUp":   salesChange >= 0,
			"Years":             years,
			"YearlySalesTotals": yearlyValues,
			"MonthlyRevenue":    monthlyRevenue,
		}

		err = tmpl.ExecuteTemplate(w, "ownerdashboard", data)
		if err != nil {
			http.Error(w, "Template execution error: "+err.Error(), http.StatusInternalServerError)
			return
		}
	}
}
