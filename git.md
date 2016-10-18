<h1>git学习笔记</h1>
	<h2>撤销修改</h2>
	<p>场景1.仅保存到工作区，git checkout -- filename;
	<p>场景2.提交到缓冲区，git reset HEAD filename,此时再按照场景1即可
	<p>场景3.提交到版本库，版本回退，git reset --hard 版本号</p>
	<h2>删除</h2>
	<p>直接删除某个文件后，版本库和工作区就不一致了，git status会告诉删除了哪些文件，此时有两个选择：<p>    1.确实要删除该文件，可以使用git rm filename,并使用git commit提交<p>    2.另一种情况是删错了，使用git checkout -- filename恢复</p>
	<h2>远程仓库</h2>
	<p>要关联一个远程库，使用命令git remote add origin git@server-name:path/repo-name.git；
	<p>关联后，使用命令git push -u origin master第一次推送master分支的所有内容；<p>此后，每次本地提交后，只要有必要，就可以使用命令git push origin master推送最新修改；  <p>分布式版本系统的最大好处之一是在本地工作完全不需要考虑远程库的存在，也就是有没有联网都可以正常工作，而SVN在没有联网的时候是拒绝干活的！<p>当有网络的时候，再把本地提交推送一下就完成了同步，真是太方便了！<p>要克隆一个仓库，首先必须知道仓库的地址，然后使用git clone命令克隆。</p>
	<h2>分支</h2>
	<p>查看分支 git branch
	<p>创建分支 git branch filename</p>
	<p>切换分支 git checkout filename</p>
	<p>创建加切换分支 git branch -b filename</p>
	<p>合并分支到当前分支 git merge filename</p>
	<p>删除分支 git branch -d filename</p>
	</div>