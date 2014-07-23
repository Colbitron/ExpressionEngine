require './bootstrap.rb'

feature 'Translate Tool' do

	before(:each) do
		cp_session
		@page = Translate.new
		@page.load

		@page.displayed?
		@page.title.text.should eq 'English Language Files'
		@page.should have_phrase_search
		@page.should have_search_submit_button
		@page.should have_bulk_action
		@page.should have_action_submit_button
	end

	it 'shows the English Language files' do
		@page.should have_pagination
		@page.should have(5).pages
		@page.pages.map {|name| name.text}.should == ["First", "1", "2", "Next", "Last"]

		@page.should have(51).rows # 50 rows per page + header row
	end

end